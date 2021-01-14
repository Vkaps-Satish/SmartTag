/**
 * Wyswig ajax management.
 *
 * @type {{init: ShopMagic.wyswig.init, init_buttons: ShopMagic.wyswig.init_buttons}}
 */
ShopMagic.wyswig = {
    /**
     * Initialize wyswig with a given unique id. There must be one wp editor with 'shopmagic_editor' id on the page.
     * @param id
     */
    init: function (id) {
        var $ = jQuery;

        if (typeof tinymce === 'undefined' || typeof tinyMCEPreInit.mceInit.shopmagic_editor === 'undefined') {
            return;
        }

        var $wrap,
            mceInit,
            qtInit,
            qtags;

        mceInit = $.extend({}, tinyMCEPreInit.mceInit.shopmagic_editor);
        qtInit = $.extend({}, tinyMCEPreInit.qtInit.shopmagic_editor);

        mceInit.selector = '#' + id;
        mceInit.id = id;
        mceInit.wp_autoresize_on = false;

        tinyMCEPreInit.mceInit[mceInit.id] = mceInit;


        qtInit.id = id;

        $wrap = tinymce.$('#wp-' + id + '-wrap');

        if (($wrap.hasClass('tmce-active') || !tinyMCEPreInit.qtInit.hasOwnProperty(id))) {

            try {
                tinymce.init(mceInit);
            } catch (e) {
                console.log(e);
            }
        }

        try {
            qtags = quicktags(qtInit);
            this.init_buttons(qtags);

        } catch (e) {
            console.log(e);
        }
    },

    /**
     * Initialize quicktags button on wyswig instance.
     *
     * @param qtags
     */
    init_buttons: function (qtags) {
        var $ = jQuery;

        var defaults = ',strong,em,link,block,del,ins,img,ul,ol,li,code,more,close,';

        var name = qtags.name;
        var settings = qtags.settings;
        var html = '';
        var theButtons = {};
        var use = '';

        // set buttons
        if (settings.buttons) {
            use = ',' + settings.buttons + ',';
        }

        for (var i in edButtons) {
            if (!edButtons[i]) {
                continue;
            }

            id = edButtons[i].id;
            if (use && defaults.indexOf(',' + id + ',') !== -1 && use.indexOf(',' + id + ',') === -1) {
                continue;
            }

            if (!edButtons[i].instance || edButtons[i].instance === inst) {
                theButtons[id] = edButtons[i];

                if (edButtons[i].html) {
                    html += edButtons[i].html(name + '_');
                }
            }
        }

        if (use && use.indexOf(',fullscreen,') !== -1) {
            theButtons.fullscreen = new qt.FullscreenButton();
            html += theButtons.fullscreen.html(name + '_');
        }


        if ('rtl' === document.getElementsByTagName('html')[0].dir) {
            theButtons.textdirection = new qt.TextDirectionButton();
            html += theButtons.textdirection.html(name + '_');
        }

        qtags.toolbar.innerHTML = html;
        qtags.theButtons = theButtons;

    }
};


jQuery(function ($) {

    if ($("#_shopmagic_edit_page").length) { // check if it is our edit page (in event metabox code)

        if ($('#shopmagic_placeholders_metabox').length) { // if placeholders metabox present
            // hide it by default
            $('#shopmagic_placeholders_metabox').hide();
        }

        var eventDataDomain = [];
        var actionsDataDomain = [];

        var actionLoadQueue = [];
        var loadLock = false;

        // load event parameter controls
        var eventChange = function () {

            if ($("#_event").val().length) {
                $.ajax({
                    url: ShopMagic.ajaxurl,
                    method: 'POST',
                    data: {
                        'action': 'shopmagic_load_event_params',
                        'event_slug': $("#_event").val(),
                        'post': $("#post_ID").val(),
                        paramProcessNonce: ShopMagic.paramProcessNonce
                    },
                    beforeSend: function (xhr) {
                        $("#shopmagic_event_metabox .spinner").addClass("is-active");
                        $("#shopmagic_event_metabox .error-icon").removeClass("error-icon-visible");
                    }
                }).done(function (data, textStatus, jqXHR) {

                    if (data.length) {
                        params = JSON.parse(data);
                        $("#event-config-area").html(params.event_box);

                        // Event description
                        $("#event-desc-area .content").html(params.description_box);

                        $("#_shopmagic_placeholders_area").html(params.placeholders_box);
                        $('#shopmagic_placeholders_metabox').show();
                        eventDataDomain = params.data_domains;
                        checkDataDomains();
                    } else {
                        $('#shopmagic_placeholders_metabox').hide();
                    }

                }).fail(function (data, textStatus, jqXHR) {
                    $("#shopmagic_event_metabox .error-icon").addClass("error-icon-visible");

                }).always(function (data, textStatus, jqXHR) {
                    $("#shopmagic_event_metabox .spinner").removeClass("is-active");

                });
            }

        };
        // Initilize Event
        $("#_event").change(eventChange);


        // load filter parameter controls
        var filterChange = function () {

            if ($("#_filter").val().length) {
                $.ajax({
                    url: ShopMagic.ajaxurl,
                    method: 'POST',
                    data: {
                        'action': 'shopmagic_load_filter_params',
                        'filter_slug': $("#_filter").val(),
                        'post': $("#post_ID").val(),
                        paramProcessNonce: ShopMagic.paramProcessNonce
                    },
                    beforeSend: function (xhr) {
                        $("#shopmagic_filter_metabox .spinner").addClass("is-active");
                        $("#shopmagic_filter_metabox .error-icon").removeClass("error-icon-visible");
                    }
                }).done(function (data, textStatus, jqXHR) {

                    if (data.length) {
                        params = JSON.parse(data);
                        $("#filter-config-area").html(params.filter_box);

                        // Filter description
                        $("#filter-desc-area .content").html(params.description_box);
                    } else {
                        $('#shopmagic_placeholders_metabox').hide();
                    }

                }).fail(function (data, textStatus, jqXHR) {
                    $("#shopmagic_filter_metabox .error-icon").addClass("error-icon-visible");

                }).always(function (data, textStatus, jqXHR) {
                    $("#shopmagic_filter_metabox .spinner").removeClass("is-active");

                });
            }

        };
        // Initiliaze Filter
        $("#_filter").change(filterChange);


        // put action to the load queue
        var putInQueue = function (currentId, control) {

            $("#action-area-" + currentId + " .spinner").addClass("is-active");
            $("#action-area-" + currentId + " .error-icon").removeClass("error-icon-visible");

            actionLoadQueue.push({
                id: currentId,
                obj: control
            });

            checkQueue();
        };

        // put action to the load queue
        var checkQueue = function () {

            if (loadLock === false && actionLoadQueue.length > 0) {
                var descriptor = actionLoadQueue.shift();
                actionLoad(descriptor.id, descriptor.obj);
            }
        };

        // process action loading
        var actionLoad = function (currentId, control) {
            var self = control;
            if ($(self).val().length) {
                $.ajax({
                    url: ShopMagic.ajaxurl,
                    method: 'POST',
                    data: {
                        'action': 'shopmagic_load_action_params',
                        'action_slug': $(self).val(),
                        'action_id': currentId,
                        'post': $("#post_ID").val(),
                        'editor_initialized': window.SM_EditorInitialized === true,
                        paramProcessNonce: ShopMagic.paramProcessNonce
                    },
                    beforeSend: function (xhr) {
                        // $("#action-area-"+currentId+" .spinner").addClass("is-active");
                        // $("#action-area-"+currentId+" .error-icon").removeClass("error-icon-visible");
                        loadLock = true;
                    }
                }).done(function (data, textStatus, jqXHR) {

                    if (data.length) {
                        params = JSON.parse(data);
                        actionsDataDomain[currentId] = params.data_domains;
                        $("#action-config-area-" + currentId).html(params.action_box);//.tinymce_textareas();
                        checkDataDomains();
                    }

                }).fail(function (data, textStatus, jqXHR) {
                    $("#action-area-" + currentId + " .error-icon").addClass("error-icon-visible");

                }).always(function (data, textStatus, jqXHR) {
                    $("#action-area-" + currentId + " .spinner").removeClass("is-active");
                    loadLock = false;
                    checkQueue();
                });
            }
        };

        // load action parameter controls
        var actionChange = function (event) {
            event.stopPropagation();
            // to avoid possible closure issues
            var self = this;
            var currentId = $(self).parent().find(".action_number").text() - 1;

            putInQueue(currentId, self);
            //actionLoad(currentId, self);

        };

        var checkDataDomains = function () {
        	return true;

            for (var i = 0; i < actionsDataDomain.length; i++) {

                // here we check each element in action Data domain to be same in event data domain
                if (actionsDataDomain[i].length > 0) { // action requires some data

                    var actionFit = true;

                    for (var j = 0; j < actionsDataDomain[i].length; j++) {

                        if (eventDataDomain.indexOf(actionsDataDomain[i][j]) == -1) {
                            actionFit = false;
                            break;
                        }
                    }

                    if (!actionFit) {
                        if (!$('#action-area-' + i + ' .wrong_action_alert').length) {
                            $('#action-area-' + i).addClass('wrong_action');
                            $('<div class="notice notice-error"><p>Some data required by this action is unavailable in the event and the action may not work correctly</p></div>').insertBefore('#action-area-' + i + ' > h2');
                        }

                    } else {
                        $('#action-area-' + i).removeClass('wrong_action');
                        $('#action-area-' + i + ' .wrong_action_alert').remove();
                    }

                }
            }
        };

        // adds new action in admin panel
        window.addNewAction = function () {

            // locate temaplte area for a new action
            var newActionArea = $("#action-area-stub").clone().insertAfter(".action-form-table:last");

            // create new ids for a new action control
            newActionArea.attr('id', "action-area-" + nextActionIndex);

            newActionArea.find("#action-config-area-stub").attr('id', "action-config-area-" + nextActionIndex);
            newActionArea.find("#_action_stub")
                .attr('id', "_actions_" + nextActionIndex + "_action")
                .attr('name', "actions[" + nextActionIndex + "][_action]");

            newActionArea.find(".action_main_select").change(actionChange);
            newActionArea.find(".action_main_select").click(actionSelClick);
            newActionArea.find(".action_number").html(nextActionIndex + 1);

            newActionArea.find("#_action_title_stub").attr('id', "_action_title_" + nextActionIndex);
            newActionArea.find("#action_title_label_stub")
                .attr('id', "action_title_label" + nextActionIndex + "_action")
                .attr('for', "action_title_input_" + nextActionIndex);
            newActionArea.find("#action_title_stub")
                .attr('id', "action_title_input_" + nextActionIndex)
                .attr('name', "actions[" + nextActionIndex + "][_action_title]")
                .on('input', titleChange);

            // new IDs Classes and Names for addon elements
            // choose 'occ' ( occurrence ) like the piece of texte to replace, we may change it
            elem_suffix = 'occ';
            elem_attribs = ['id', 'class', 'name', 'for'];

            change_suffix_for(newActionArea, elem_attribs, elem_suffix, nextActionIndex);

            nextActionIndex++;
            return false;

        };

        /*
        *   for every element in 'parent_elem' change the 'elem_attribs' attribs names containing 'old_suffix'
        *   with the 'new_suffix'
        *   note : suffix stands for suffix and prefix and inner text as well
        */
        window.change_suffix_for = function (parent_elem, elem_attribs, old_suffix, new_suffix) {
            jQuery.each(elem_attribs, function (ind, attrib) {
                parent_elem.find("[" + attrib + "*='" + old_suffix + "']").each(function (index) {
                    old_id_name = jQuery(this).attr(attrib);  // '$' => ends with
                    new_id_name = old_id_name.replace(old_suffix, new_suffix);
                    jQuery(this).attr(attrib, new_id_name);
                });
            });
        };

        window.actionSelClick = function (event) {
            event.stopPropagation();
        };

        window.removeAction = function (element) {

            $(element).parent().parent().parent().parent().parent().parent().remove();
            return false;

        };

        window.titleChange = function (element) {
            var id = $(this).attr('id').split('_')[3];

            $('#_action_title_' + id).text($(this).val());
        };

        $(".action_main_select").change(actionChange);
        $(".action_main_select").click(actionSelClick);
        $(".action_title_input").on('input', titleChange);


        $(function () {
            // on page load initialize events edit controls
            eventChange();
            filterChange();

            // for each action edit control loads content
            var actions = $('*[class^="action_main_select"]');
            actions.trigger('change');

        });

        // load email template and put it in the editor
        window.loadEmailTemplate = function (editorId) {

            var templateName = $('#predefined_block_' + editorId).val();


            $.ajax({
                url: ShopMagic.ajaxurl,
                method: 'POST',
                data: {
                    'action': 'sm_sea_load_email_template',
                    'template_slug': templateName,
                    paramProcessNonce: ShopMagic.paramProcessNonce
                },
                beforeSend: function (xhr) {
                    $('.email_templates_' + editorId + ' .spinner').addClass('is-active');
                    $('.email_templates_' + editorId + ' .error-icon').removeClass('error-icon-visible');
                }
            }).done(function (data, textStatus, jqXHR) {

                tinymce.execCommand('mceFocus', false, editorId);
                tinymce.activeEditor.execCommand('mceInsertContent', false, data);

            }).fail(function (data, textStatus, jqXHR) {
                $('.email_templates_' + editorId + ' .error-icon').addClass('error-icon-visible');

            }).always(function (data, textStatus, jqXHR) {
                $('.email_templates_' + editorId + ' .spinner').removeClass('is-active');
            });


            return false;
        }

    }
});
