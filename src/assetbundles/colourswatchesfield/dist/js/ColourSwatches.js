ColourSelectInput = Garnish.Base.extend({

    $container: null,
    $options: null,
    $selectedOption: null,
    $input: null,

    init: function(id)
    {
        this.$container = $('#'+id);
        this.$options = this.$container.find('.option');
        this.$selectedOption = this.$options.filter('.button-active');
        this.$input = this.$container.next('input');

        this.addListener(this.$options, 'click', 'onOptionSelect');
    },

    onOptionSelect: function(ev)
    {
        var $option = $(ev.currentTarget);

        // enables toggle on/off function of color buttons
        if ($option.hasClass('button-active'))
        {
            $option.removeClass('button-active');
            this.$selectedOption = null;
            this.$input.val('');
            return;
        }

        if (this.$selectedOption) {
            this.$selectedOption.removeClass('button-active');
        }
        this.$selectedOption = $option.addClass('button-active');
        this.$input.val(JSON.stringify($option.data('value')));
    }

});