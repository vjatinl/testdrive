
/*   TOOLTIP JS START  */
$(function() {
    if($("*").hasClass("upload")) {
        $('.upload').tooltip();
    }
});

$(function() {
    if($("*").hasClass("sr-tooltip")) {
        $('.sr-tooltip').tooltip({html: true});
    }
});
/*   TOOLTIP JS  END */

/*   COLLAPSE JS START  */
$(function () {
    if($("*").hasClass("group1")) {
        $('.group1').simpleexpand();
    }
});

(function ($) {
    "use strict";

    // SimpleExpand
    function SimpleExpand() {

        var that = this;

        that.defaults = {

            'hideMode': 'fadeToggle',
			'defaultSearchMode': 'parent',
            'defaultTarget': '.content',
            'throwOnMissingTarget': true,
            'keepStateInCookie': false,
            'cookieName': 'simple-expand'
        };

        that.settings = {};
        $.extend(that.settings, that.defaults);

      that.findLevelOneDeep = function (parent, filterSelector, stopAtSelector) {
            return parent.find(filterSelector).filter(function () {
                return !$(this).parentsUntil(parent, stopAtSelector).length;
            });
        };

        that.setInitialState = function (expander, targets) {
            var isExpanded = that.readState(expander);

            if (isExpanded) {
                expander.removeClass("collapsed").addClass("expanded");
                that.show(targets);
            } else {
                expander.removeClass("expanded").addClass("collapsed");
                that.hide(targets);
            }
        };

        that.hide = function (targets) {
            if (that.settings.hideMode === "fadeToggle") {
                targets.hide();
            } else if (that.settings.hideMode === "basic") {
                targets.hide();
            }
        };

        that.show = function (targets) {
            if (that.settings.hideMode === "fadeToggle") {
                targets.show();
            } else if (that.settings.hideMode === "basic") {
                targets.show();
            }
        };

        that.checkKeepStateInCookiePreconditions = function () {
            if (that.settings.keepStateInCookie && $.cookie === undefined){
                throw new Error("simple-expand: keepStateInCookie option requires $.cookie to be defined.");
            }
        };

               that.readCookie = function () {
            var jsonString = $.cookie(that.settings.cookieName);
            if ( jsonString === null  || jsonString === '' || jsonString === undefined ){
                return {};
            }
            else{
                return JSON.parse(jsonString);
            }
        };


        that.readState = function (expander) {

            if (!that.settings.keepStateInCookie){
                 return expander.hasClass("expanded");
            }

            var id = expander.attr('Id');
            if (id === undefined){
                return;
            }

            var cookie = that.readCookie();
            var cookieValue = cookie[id];


            if (typeof cookieValue !== "undefined"){
                return cookie[id] === true;
            }
            else{

                return expander.hasClass("expanded");
            }
        };


        that.saveState = function (expander, isExpanded) {
            if (!that.settings.keepStateInCookie){
                return;
            }

            var id = expander.attr('Id');
            if (id === undefined){
                return;
            }

            var cookie = that.readCookie();
            cookie[id] = isExpanded;
            $.cookie(that.settings.cookieName, JSON.stringify(cookie), { raw: true, path:window.location.pathname });
        };


        that.toggle = function (expander, targets) {

            var isExpanded = that.toggleCss(expander);

            if (that.settings.hideMode === "fadeToggle") {
                targets.fadeToggle(150);
            } else if (that.settings.hideMode === "basic") {
                targets.toggle();
            } else if ($.isFunction(that.settings.hideMode)) {
                that.settings.hideMode(expander, targets, isExpanded);
            }

            that.saveState(expander, isExpanded);


            return false;
        };


        that.toggleCss = function (expander) {
            if (expander.hasClass("expanded")) {
                expander.toggleClass("collapsed expanded");
                return false;
            }
            else {
                expander.toggleClass("expanded collapsed");
                return true;
            }
        };


        that.findTargets = function (expander, searchMode, targetSelector) {

            var targets = [];
            if (searchMode === "absolute") {
                targets = $(targetSelector);
            }
            else if (searchMode === "relative") {
                targets = that.findLevelOneDeep(expander, targetSelector, targetSelector);
            }
            else if (searchMode === "parent") {


                var parent = expander.parent();
                do {
                    targets = that.findLevelOneDeep(parent, targetSelector, targetSelector);


                    if (targets.length === 0) {
                        parent = parent.parent();
                    }
                } while (targets.length === 0 && parent.length !== 0);
            }
            return targets;
        };

        that.activate = function (jquery, options) {
            $.extend(that.settings, options);

            that.checkKeepStateInCookiePreconditions();



            jquery.each(function () {
                var expander = $(this);

                var targetSelector = expander.attr("data-expander-target") || that.settings.defaultTarget;
                var searchMode = expander.attr("data-expander-target-search") || that.settings.defaultSearchMode;

                var targets = that.findTargets(expander, searchMode, targetSelector);

                if (targets.length === 0) {
                    if (that.settings.throwOnMissingTarget) {
                        throw "simple-expand: Targets not found";
                    }
                    return this;
                }

                that.setInitialState(expander, targets);


                expander.click(function () {
                    return that.toggle(expander, targets);
                });
            });
        };
    }


    window.SimpleExpand = SimpleExpand;


    $.fn.simpleexpand = function (options) {
        var instance = new SimpleExpand();
        instance.activate(this, options);
        return this;
    };
}(jQuery));

/*   COLLAPSE JS END  */




/*   CHECKBOX JS START   */
$(window).on('load', function () {

    if($("*").hasClass("selectpicker")) {
        $('.selectpicker').selectpicker({
            'selectedText': 'cat'
        });
    }

    if($("*").hasClass("checkbox")) {
        $('.checkbox').checkbox();
    }

	// $('.selectpicker').selectpicker('hide');
});

!function($) {
    var Checkbox = function(element, options, e) {
        if (e) {
            e.stopPropagation();
            e.preventDefault();
        }
        this.$element = $(element);
        this.$newElement = null;
        this.button = null;
        this.label = null;
        this.labelPrepend = null;
        this.options = $.extend({}, $.fn.checkbox.defaults, this.$element.data(), typeof options == 'object' && options);
        this.displayAsButton = this.options.displayAsButton;
        this.buttonStyle = this.options.buttonStyle;
        this.buttonStyleChecked = this.options.buttonStyleChecked;
        this.defaultState = this.options.defaultState;
        this.defaultEnabled = this.options.defaultEnabled;
        this.indeterminate = this.options.indeterminate;
        this.init();
    };

    Checkbox.prototype = {

        constructor: Checkbox,

        init: function (e) {
            this.$element.hide();
            this.$element.attr('autocomplete', 'off');
            var classList = this.$element.attr('class') !== undefined ? this.$element.attr('class').split(/\s+/) : '';
            var template = this.getTemplate();
            this.$element.after(template);
            this.$newElement = this.$element.next('.bootstrap-checkbox');
            this.button = this.$newElement.find('button');
            this.label = this.$newElement.find('span.label-checkbox');
            this.labelPrepend = this.$newElement.find('span.label-prepend-checkbox');
            for (var i = 0; i < classList.length; i++) {
                if(classList[i] != 'checkbox') {
                    this.$newElement.addClass(classList[i]);
                }
            }
            this.button.addClass(this.buttonStyle);

            if (this.$element.data('default-state') != undefined){
            	this.defaultState = this.$element.data('default-state');
            }
            if (this.$element.data('default-enabled') != undefined){
            	this.defaultEnabled = this.$element.data('default-enabled');
            }
            if (this.$element.data('display-as-button') != undefined){
            	this.displayAsButton = this.$element.data('display-as-button');
            }
            if (this.$element.data('indeterminate') != undefined){
            	this.indeterminate = this.$element.data('indeterminate');
            }

            if (this.indeterminate)
            	this.$element.prop('indeterminate', true);

            this.checkEnabled();
            this.checkChecked();
            this.checkTabIndex();
            this.clickListener();
        },

        getTemplate: function() {
            var additionalButtonStyle = this.displayAsButton ? ' displayAsButton' : '',
            	label = this.$element.data('label') ? '<span class="label-checkbox">'+this.$element.data('label')+'</span>' : '',
            	labelPrepend = this.$element.data('label-prepend') ? '<span class="label-prepend-checkbox">'+this.$element.data('label-prepend')+'</span>' : '';

            var template =
            	'<span class="button-checkbox bootstrap-checkbox">' +
            		'<button type="button" class="btn clearfix'+additionalButtonStyle+'">' +
            			((this.$element.data('label-prepend') && this.displayAsButton) ? labelPrepend : '')+
	                    '<span class="icon '+this.options.checkedClass+'" style="display:none;"></span>' +
	                    '<span class="icon '+this.options.uncheckedClass+'"></span>' +
	                    '<span class="icon '+this.options.indeterminateClass+'" style="display:none;"></span>' +
	                    ((this.$element.data('label') && this.displayAsButton) ? label : '')+
	                '</button>' +
	            '</span>';

            if (!this.displayAsButton && (this.$element.data('label') || this.$element.data('label-prepend'))) {
            	template =
            		'<label class="'+this.options.labelClass+'">' +
            			labelPrepend + template + label+
		            '</label>';
            }
            return template;
        },

        checkEnabled: function() {
        	this.button.attr('disabled', this.$element.is(':disabled'));
        	this.$newElement.toggleClass('disabled', this.$element.is(':disabled'));
        },

		checkTabIndex: function() {
			if (this.$element.is('[tabindex]')) {
				var tabindex = this.$element.attr("tabindex");
				this.button.attr('tabindex', tabindex);
			}
		},

		checkChecked: function() {
			var whitePattern = /\s/g, replaceChar = '.';
			if (this.$element.prop('indeterminate') == true){
				this.button.find('span.'+this.options.checkedClass.replace(whitePattern, replaceChar)).hide();
				this.button.find('span.'+this.options.uncheckedClass.replace(whitePattern, replaceChar)).hide();
				this.button.find('span.'+this.options.indeterminateClass.replace(whitePattern, replaceChar)).show();
			} else {
				if (this.$element.is(':checked')) {
					this.button.find('span.'+this.options.checkedClass.replace(whitePattern, replaceChar)).show();
					this.button.find('span.'+this.options.uncheckedClass.replace(whitePattern, replaceChar)).hide();
				} else {
					this.button.find('span.'+this.options.checkedClass.replace(whitePattern, replaceChar)).hide();
					this.button.find('span.'+this.options.uncheckedClass.replace(whitePattern, replaceChar)).show();
				}
				this.button.find('span.'+this.options.indeterminateClass.replace(whitePattern, replaceChar)).hide();
			}

			if (this.$element.is(':checked')) {
				if (this.buttonStyleChecked){
					this.button.removeClass(this.buttonStyle);
					this.button.addClass(this.buttonStyleChecked);
				}
			} else {
				if (this.buttonStyleChecked){
					this.button.removeClass(this.buttonStyleChecked);
					this.button.addClass(this.buttonStyle);
				}
			}

			if (this.$element.is(':checked')) {
				if (this.options.labelClassChecked){
					$(this.$element).next("label").addClass(this.options.labelClassChecked);
				}
			} else {
				if (this.options.labelClassChecked){
					$(this.$element).next("label").removeClass(this.options.labelClassChecked);
				}
			}
		},

        clickListener: function() {
        	var _this = this;
        	this.button.on('click', function(e){
				e.preventDefault();
				_this.$element.prop("indeterminate", false);
				_this.$element[0].click();
				_this.checkChecked();
        	});
		this.$element.on('change', function(e) {
			_this.checkChecked();
		});
		this.$element.parents('form').on('reset', function(e) {
	        if (_this.defaultState == null){
	        	_this.$element.prop('indeterminate', true);
	        } else {
	        	_this.$element.prop('checked', _this.defaultState);
	        }
        	_this.$element.prop('disabled', !_this.defaultEnabled);
        	_this.checkEnabled();
        	_this.checkChecked();
        	e.preventDefault();
		});
        },

        setOptions: function(option, event){
	        if (option.checked != undefined) {
	        	this.setChecked(option.checked);
	        }
	        if (option.enabled != undefined) {
	        	this.setEnabled(option.enabled);
	        }
	        if (option.indeterminate != undefined) {
	        	this.setIndeterminate(option.indeterminate);
	        }
        },

        setChecked: function(checked){
        	this.$element.prop("checked", checked);
        	this.$element.prop("indeterminate", false);
        	this.checkChecked();
        },

        setIndeterminate: function(indeterminate){
        	this.$element.prop("indeterminate", indeterminate);
        	this.checkChecked();
        },


        click: function(event){
        	this.$element.prop("indeterminate", false);
        	this.$element[0].click();
        	this.checkChecked();
        },

        change: function(event){
        	this.$element.change();
        },

        setEnabled: function(enabled){
        	this.$element.attr('disabled', !enabled);
        	this.checkEnabled();
        },

        toggleEnabled: function(event){
        	this.$element.attr('disabled', !this.$element.is(':disabled'));
        	this.checkEnabled();
        },

        refresh: function(event){
        	this.checkEnabled();
        	this.checkChecked();
        }

    };

    $.fn.checkbox = function(option, event) {
        return this.each(function () {
            var $this = $(this),
                data = $this.data('checkbox'),
                options = typeof option == 'object' && option;
            if (!data) {
                $this.data('checkbox', (data = new Checkbox(this, options, event)));
                if (data.options.constructorCallback != undefined){
                	data.options.constructorCallback(data.$element, data.button, data.label, data.labelPrepend);
                }
            } else {
            	if (typeof option == 'string') {
                    data[option](event);
                } else if (typeof option != 'undefined') {
                	data.setOptions(option, event);
                }
            }
        });
    };

    $.fn.checkbox.defaults = {
    	displayAsButton: false,
    	indeterminate: false,
    	buttonStyle: 'btn-link',
        buttonStyleChecked: null,
        checkedClass: 'cb-icon-check',
        uncheckedClass: 'cb-icon-check-empty',
        indeterminateClass: 'cb-icon-check-indeterminate',
        defaultState: false,
        defaultEnabled: true,
        constructorCallback: null,
	labelClass: "checkbox bootstrap-checkbox",
	labelClassChecked: "active"
    };

}(window.jQuery);
/*  CHECK BOX JS END  */

function openAjaxPopup(ajaxUrl)
{
    if($('#ajaxModal').length > 0)
        $('#ajaxModal').remove();
    //e.preventDefault();

    var $this = $(this)
            , $remote = ajaxUrl
            , $modal = $('<div class="modal" id="ajaxModal"><div class="modal-body"></div></div>');

    $('body').append($modal);
    $modal.modal({backdrop: 'static', keyboard: false});
    $modal.load($remote);
}

function showjobs(id,titleText) {
    $.ajax({
        type: "GET",
        url: SITE_URL + "/admin/jobs/view/" + id,
        success: function(data) {
            bootbox.dialog({
                closeButton: false,
                animate: false,
                title: false,
                message: data,
                buttons: {
                    success: {
                        label: "Okay",
                        className: "btn-success",
                        callback: function () {
                            
                        }
                    }
                }
            });
        }
    });
}
// hack to prevent auto fill on chrome
/*$(window).load(function() {
    setTimeout(function() {
        if ( navigator.userAgent.toLowerCase().indexOf('chrome') >= 0 ) {
            $('input[autocomplete="off"]').each( function(){
                $(this).val('');
            });
        }
    },100);
});*/

/**http://ericprieto.com/freebie/simply-toast/**/
(function()
{
	$.simplyToast = function(message, type, options)
	{
		options = $.extend(true, {}, $.simplyToast.defaultOptions, options);

		var html = '<div class="simply-toast alert alert-' + (type ? type : options.type) + ' ' + (options.customClass ? options.customClass : '') +'">';
			if(options.allowDismiss)
				html += '<span class="close" data-dismiss="alert">&times;</span>';
			html += message;
			html += '</div>';

		var offsetSum = options.offset.amount;
        if(!options.stack)
		{   $('.simply-toast').each(function()
            {
                return offsetSum = Math.max(offsetSum, parseInt($(this).css(options.offset.from)) + this.offsetHeight + options.spacing);
            });
        }
        else
        {
            $(options.appendTo).find('.simply-toast').each(function()
            {
                return offsetSum = Math.max(offsetSum, parseInt($(this).css(options.offset.from)) + this.offsetHeight + options.spacing);
            });
        }

		var css =
		{
			'position': (options.appendTo === 'body' ? 'fixed' : 'absolute'),
			'margin': 0,
			'z-index': '9999',
			'display': 'none',
			'min-width': options.minWidth,
			'max-width': options.maxWidth
		};

		css[options.offset.from] = offsetSum + 'px';

		var $alert = $(html).css(css)
							.appendTo(options.appendTo);

		switch (options.align)
		{
			case "center":
				$alert.css(
				{
					"left": "50%",
                    "top":"20%",
					"margin-left": "-" + ($alert.outerWidth() / 2) + "px"
				});
				break;
			case "left":
				$alert.css("left", "20px");
				break;
			default:
				$alert.css("right", "20px");
		}

		if($alert.fadeIn) $alert.fadeIn();
		else $alert.css({display: 'block', opacity: 1});

		function removeAlert()
		{
			$.simplyToast.remove($alert);
		}

		if(options.delay > 0)
		{
			setTimeout(removeAlert, options.delay);
		}

		$alert.find("[data-dismiss=\"alert\"]").removeAttr('data-dismiss').click(removeAlert);

		return $alert;
	};

	$.simplyToast.remove = function($alert)
	{
		if($alert.fadeOut)
		{
			return $alert.fadeOut(function()
			{
				return $alert.remove();
			});
		}
		else
		{
			return $alert.remove();
		}
	};

	$.simplyToast.defaultOptions = {
		appendTo: "body",
        stack: false,
		customClass: false,
		type: "success",
		offset:
		{
			from: "top",
			amount: 20
		},
		align: "center",
		minWidth: 250,
		maxWidth: 450,
		delay: 6000,
		allowDismiss: true,
		spacing: 10
	};
})();