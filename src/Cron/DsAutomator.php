<?php

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Doublespark\Cron;

/**
* Provide methods to run automated jobs.
*
* @author Leo Feyer <https://github.com/leofeyer>
*/
class DsAutomator extends \System {

    /**
     * Make the constuctor public
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Update local assets
     */
    public function updateLocalAssets()
    {
        $objAssets = \Database::getInstance()->query('SELECT id,url,last_updated FROM tl_ds_local_assets');

        if($objAssets->numRows > 0)
        {
            while($objAssets->next())
            {
                $filename = basename($objAssets->url);

                // Don't update if this asset has been updated in the last hour
                if($objAssets->last_updated > (time() - 3600))
                {
                    continue;
                }

                if($this->fetchRemoteAsset($objAssets->url))
                {
                    \Database::getInstance()->prepare('UPDATE tl_ds_local_assets SET last_updated=? WHERE id=?')->execute(time(),$objAssets->id);

                    // Add a log entry
                    $this->log('Fetched most recent version of '.$filename, __METHOD__, TL_CRON);
                }
                else
                {
                    // Add a log entry
                    $this->log('Could not fetch '.$objAssets->url.'. Connection failed.', __METHOD__, TL_ERROR);
                }
            }
        }
    }

    /**
     * Fetches remote asset and saves it locally
     * @param $url
     * @return bool
     */
    protected function fetchRemoteAsset($url)
    {
        $localfile = TL_ROOT.'/web/local-assets/'.basename($url);

        // Create directory if it doesn't exist
        if (!file_exists(TL_ROOT.'/web/local-assets')) {
            mkdir(TL_ROOT.'/web/local-assets', 0775, true);
        }

        $curl = curl_init($url);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'
        ]);

        $response = curl_exec($curl);
        $retcode  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($response === false || $retcode >= 400)
        {
            return false;
        }

        if(file_put_contents($localfile, $response))
        {
            return true;
        }

        return false;
    }

}