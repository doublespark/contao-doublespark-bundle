/**
 * Adds a floating save button
 */
window.addEvent('domready', function() {

    var saveButton      = document.getElementById('save');
    var saveCloseButton = document.getElementById('saveNclose');

    if(saveButton && saveCloseButton) {

        var container = $('container');

        var saveButtonHTML = Elements.from('<div class="custom-save"><a href="#">Save</a></div>');
        var saveClosebuttonHTML = Elements.from('<div class="custom-save"><a href="#">Save & Close</a></div>');

        var positionButtons = function () {
            var scroll = document.getScroll();
            saveButtonHTML.setStyle('top', scroll.y + 2);
            saveClosebuttonHTML.setStyle('top', scroll.y + 60);
        };

        positionButtons();

        saveButtonHTML[0].inject(container);
        saveClosebuttonHTML[0].inject(container);

        saveButtonHTML[0].addEvent('click', function () {
            saveButton.click();
            return false;
        });

        saveClosebuttonHTML[0].addEvent('click', function () {
            saveCloseButton.click();
            return false;
        });

        window.addEvent('scroll', function () {
            positionButtons();
        });
    }
});