window.addEvent('domready', function() {

    // Get the inputs
    var titleInput       = $('ctrl_pageTitle');
    var descriptionInput = $('ctrl_description');

    if(titleInput && descriptionInput) {

        // Set the character limits
        var maxDescriptionChars = 160;
        var maxTitleChars = 55;

        // Get the input wrappers
        var titleFieldWrapper = titleInput.getParent();
        var descriptionFieldWrapper = descriptionInput.getParent();

        // Add classes to input wrappers
        titleFieldWrapper.addClass('word-count-field');
        descriptionFieldWrapper.addClass('word-count-field');

        // Set class that will be added to invalid wrapper
        var invalidClass = 'word-count-invalid';

        var updateTitleCount = function () {
            var titleRemaining = maxTitleChars - titleInput.get('value').length;

            $(document.body).getElement('.title_remaining').set('text', titleRemaining);

            // Check the maximum title length isn't exceeded
            if (titleRemaining < 0) {
                titleFieldWrapper.addClass(invalidClass);
            }
            else {
                titleFieldWrapper.removeClass(invalidClass);
            }
        }

        var updateDescriptionCount = function () {
            var descRemaining = maxDescriptionChars - descriptionInput.get('value').length;

            $(document.body).getElement('.description_remaining').set('text', descRemaining);

            // Check the maximum description length isn't exceeded
            if (descRemaining < 0) {
                descriptionFieldWrapper.addClass(invalidClass);
            }
            else {
                descriptionFieldWrapper.removeClass(invalidClass);
            }
        }

        // Make sure we have the inputs
        if (titleInput.get('value') !== undefined && descriptionInput.get('value') !== undefined) {
            var titleRemaining = maxTitleChars - titleInput.get('value').length;
            var descRemaining = maxDescriptionChars - descriptionInput.get('value').length;

            // Build the character count HTML
            var titleHTML = Elements.from('<p class="tl_help tl_tip title-word-count">Maximum characters ' + maxTitleChars + ' | Characters remaining: <span class="title_remaining">' + titleRemaining + '</span></p>');
            var descriptionHTML = Elements.from('<p class="tl_help tl_tip desc-word-count">Maximum characters ' + maxDescriptionChars + ' | Characters remaining: <span class="description_remaining">' + descRemaining + '</span></p>');

            // Insert the character count HTML
            descriptionHTML[0].inject(descriptionInput, 'after');
            titleHTML[0].inject(titleInput, 'after');

            // Set initial counts
            updateTitleCount();
            updateDescriptionCount();

            // Update the description count as it's changed
            descriptionInput.addEvent('keyup', updateDescriptionCount);
            descriptionInput.addEvent('change', updateDescriptionCount);
            descriptionInput.addEvent('blur', updateDescriptionCount);
            descriptionInput.addEvent('focus', updateDescriptionCount);

            // Update the title count as it's changed
            titleInput.addEvent('keyup', updateTitleCount);
            titleInput.addEvent('change', updateTitleCount);
            titleInput.addEvent('blur', updateTitleCount);
            titleInput.addEvent('focus', updateTitleCount);
        }
    }
});