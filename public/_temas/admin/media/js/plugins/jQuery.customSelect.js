
/* jQuery Custom Select - TODO: Description
 * TODO: usage
 * 
 * Copyright (c) 2011 Marcos M. Lopes & Mateus C. Moura
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

var matched, browser;

// Use of jQuery.browser is frowned upon.
// More details: http://api.jquery.com/jQuery.browser
// jQuery.uaMatch maintained for back-compat
jQuery.uaMatch = function( ua ) {
	ua = ua.toLowerCase();

	var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
		/(webkit)[ \/]([\w.]+)/.exec( ua ) ||
		/(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
		/(msie) ([\w.]+)/.exec( ua ) ||
		ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
		[];

	return {
		browser: match[ 1 ] || "",
		version: match[ 2 ] || "0"
	};
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
	browser[ matched.browser ] = true;
	browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
	browser.webkit = true;
} else if ( browser.webkit ) {
	browser.safari = true;
}

jQuery.browser = browser;


/* */

(function ($) {
	var indCustomSelect = 0;
	$.fn.undoCustomSelect = function () {
		var selec = $(this);

		selec.next("div.customSelect").remove();
		selec.show();
	}
	$.fn.customSelect = function (callback) {
		$(document).click(function (e) {
			if ($(e.target).parents('.customSelect').length === 0) {
				$('.customSelect ul').hide();
				$('.customSelect').removeClass('activeDropdown');
				$('.customSelect').css("z-index", "25");
			}

			if ($(e.target).hasClass("dropdown") && $(e.target).hasClass("customSelect"))
				return false;
		});

		var dOpen = function (e) {
			if (!$(this).parents('.disabled').length) {
				var $drop = $(this);

				$('.customSelect').not($drop.parents('.customSelect'))
					.removeClass('activeDropdown')
					.find('ul').hide();

				$drop.siblings().toggle();
				$drop.parent().toggleClass('activeDropdown');

				$drop.parent().is(".activeDropdown")
					? $drop.parent().css("z-index", "30")
					: $drop.parent().css("z-index", "25");
			}

			e.preventDefault();

			return false;
		}

		var change = function (e) {
			var bts = $(this),
				customSelect = bts.parents('.customSelect'),
				selectId = customSelect.attr('id').replace('customSelectWrapper_', ''),
				index = bts.find('span.index').text(),
				valuee = bts.find('span.value').text(),
				option = $("select[rel='customSelect_" + selectId + "'] option[value='" + bts.attr("rel") + "']");

			if (!option.length) {
				option = $("select[rel='customSelect_" + selectId + "'] option")
					.filter(':contains(' + bts.attr("rel") + ')');
			}

			if( bts.hasClass('selected') ){
				customSelect.find('ul').hide();
				customSelect.removeClass('activeDropdown');
				return false;
			}
			else{
				$('a.selected', customSelect).removeClass('selected');
				bts.addClass('selected');
			}

			customSelect.find('.dropdown span span').text(valuee).removeClass("init");
			customSelect.find('ul').hide();
			customSelect.removeClass('activeDropdown');

			if ($.browser.msie && $.browser.version == '6.0') {
				/* i need to do this becouse ie 6 throw an unexpected error
				* after set select value
				*/
				try {
					$("select[rel='customSelect_" + selectId + "']").val(bts.attr("rel"));
				} catch (ex) {
					var oSelect = $("select[rel='customSelect_" + selectId + "']");

					oSelect.show().css({
						position: 'absolute',
						top: '-999em',
						left: '-999em'
					});

					setTimeout(function () { oSelect.val(bts.attr('rel')); }, 1);
				}
			} else {
				customSelect.siblings("select").val(bts.attr("rel"));
			}

			if (typeof callback == 'function') {
				//console.log(callback, option.text(), option.val())
				callback.call(option, option.text() || option.val(), customSelect);
			}

			e.preventDefault();

			return false;
		}

		var keydown = function (e) {
			var customSelect = $(this).parents('.customSelect'),
				options = customSelect.find('a'),
				content = $(this).text();

			if (!$(this).parents('.disabled').length) {
				if (e.keyCode === 40) {
					options.filter(':contains(' + content + ')').parent()
						.next().find('a').trigger('click');

					e.preventDefault();
				} else if (e.keyCode === 38) {
					options.filter(':contains(' + content + ')').parent()
						.prev().find('a').trigger('click');

					e.preventDefault();
				} else if (e.keyCode > 47 && e.keyCode < 91) {
					var code = String.fromCharCode(e.keyCode),
						rgx = new RegExp("^" + code, "gi"),
						arr;

					arr = options.filter(function () {
						return $(this).find('span.value').text().match(rgx);
					});

					if (arr.length > 1 && arr.filter(':contains(' + content + ')').length) {
						arr.each(function (i) {
							if ($(this).find('.value').text() === content) {
								$(arr[++i >= arr.length ? 0 : i]).trigger('click');
							}
						});
					} else {
						arr.trigger('click');
					}
				}
			}
		}

		return $(this).each(function (i, b, c) {
			var parent = $(this).parent(),
				customSelect = parent.find('div.customSelect'),
				wrap = $('<div id="customSelectWrapper_' + indCustomSelect + '" class="customSelect ' + $(this).attr( "name" ) + '">'),
				inner = $('<ul>'),
				options = "";

			i = indCustomSelect;
			indCustomSelect++;

			if (customSelect.length) {
				i = parseInt(customSelect.attr('id').replace('customSelectWrapper_', '')) + i;
				wrap.attr('id', 'customSelectWrapper_' + i );
			}
			wrap.addClass($(this).is(":disabled") ? "disabled" : "");

			$(this).hide().attr('rel', 'customSelect_' + i);

			$(this).find('option').each(function (i) {
				options += '<li><a href="#" rel=' + ($(this).val() == "" ? 'not' : $(this).val()) + '>';
				options += '<span class="value">' + $(this).text() + '</span>';
				options += '<span class="index">' + i + '</span>'
				options += '</a></li>';
			});

			inner.hide().append(options);

			wrap.append('<a href="#" class="dropdown"><span><span class="init">' + $(this).find('option:selected').text() + '</span></span></a>');
			wrap.append(inner);

			if (customSelect.length) {
				customSelect.remove();
			}

			$(this).after(wrap);

			var customSelect = $(this).parent().find('div.customSelect');

			customSelect.find('.dropdown').click(dOpen).keydown(keydown);
			customSelect.find('li a').click(change);
			customSelect.find('ul').jScrollPane({
				autoReinitialise: true,
				verticalDragMinHeight: 5,
				verticalDragMaxHeight: 115
			});
		});
	}

	$('.custom-select').customSelect();

})(jQuery)