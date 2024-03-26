/**
 * Adds a floating save button
 */

const contaoSaveButton      = document.getElementById('save');
const contaoSaveCloseButton = document.getElementById('saveNclose');

if(contaoSaveButton && contaoSaveCloseButton) {

    const createButton = (buttonText) => {
        const button = document.createElement('button');
        button.innerText = buttonText;
        return button;
    }

    const body = document.querySelector('body');

    const saveButton = createButton('Save');
    const saveAndCloseButton = createButton('Save & Close');

    const buttonsContainer = document.createElement('div');
    buttonsContainer.classList.add('custom-buttons');
    buttonsContainer.appendChild(saveButton);
    buttonsContainer.appendChild(saveAndCloseButton);

    const actionsButton = createButton('Actions');

    const buttonWrapper = document.createElement('div');
    buttonWrapper.classList.add('custom-buttons-wrapper');

    // Reload previous state
    if(getCookie('dsButton') === '1')
    {
        buttonWrapper.classList.add('visible');
    }

    buttonWrapper.appendChild(actionsButton);
    buttonWrapper.appendChild(buttonsContainer);

    body.appendChild(buttonWrapper);

    actionsButton.addEventListener('click', function (e) {
        e.preventDefault();
        if(buttonWrapper.classList.contains('visible'))
        {
            setCookie('dsButton', '0', 365);
        }
        else
        {
            setCookie('dsButton', '1', 365);
        }
        buttonWrapper.classList.toggle('visible');
        return false;
    });

    saveButton.addEventListener('click', function (e) {
        e.preventDefault();
        contaoSaveButton.click();
        return false;
    });

    saveAndCloseButton.addEventListener('click', function (e) {
        e.preventDefault();
        contaoSaveCloseButton.click();
        return false;
    });

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
}
