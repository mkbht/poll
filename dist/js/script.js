$(document).ready(function() {
	/* input focus */
    $('.input-group').on('focus', '.form-control', function () {
    	$(this).closest('.input-group, .form-group').addClass('focus');
    	})
    .on('blur', '.form-control', function () {
    		     $(this).closest('.input-group, .form-group').removeClass('focus');
    		   });

    $(':radio').radiocheck();
    $(':checkbox').radiocheck();
    $('[data-toggle="tooltip"]').tooltip();
    if ($('[data-toggle="switch"]').length) {
      $('[data-toggle="switch"]').bootstrapSwitch();
    }

    $("select").select2({dropdownCssClass: 'dropdown-inverse'});



    $("#uploadform").filer({
        limit: 3,
        maxSize: 3,
        extensions: ["jpg", "png", "gif"],
        changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Drag&Drop files here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn blue">Browse Files</a></div></div>',
        showThumbs: true,
        theme: "dragdropbox",
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: '<li class="jFiler-item">\
                        <div class="jFiler-item-container">\
                            <div class="jFiler-item-inner">\
                                <div class="jFiler-item-thumb">\
                                    <div class="jFiler-item-status"></div>\
                                    <div class="jFiler-item-thumb-overlay">\
                                        <div class="jFiler-item-info">\
                                            <div style="display:table-cell;vertical-align: middle;">\
                                                <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
                                                <span class="jFiler-item-others">{{fi-size2}}</span>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    {{fi-image}}\
                                </div>\
                                <div class="jFiler-item-assets jFiler-row">\
                                    <ul class="list-inline pull-left">\
                                        <li>{{fi-progressBar}}</li>\
                                    </ul>\
                                    <ul class="list-inline pull-right">\
                                        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                    </ul>\
                                </div>\
                            </div>\
                        </div>\
                    </li>',
            itemAppend: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-thumb-overlay">\
                                            <div class="jFiler-item-info">\
                                                <div style="display:table-cell;vertical-align: middle;">\
                                                    <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
                                                    <span class="jFiler-item-others">{{fi-size2}}</span>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: false,
            canvasImage: true,
            removeConfirmation: true,
            _selectors: {
                list: '.jFiler-items-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action'
            }
        },
        files: null,
        addMore: true,
        onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl){
            var filerKit = inputEl.prop("jFiler"),
                file_name = filerKit.files_list[id].name;

            $.post('./php/ajax_remove_file.php', {file: file_name});
        },
        dialogs: {
            alert: function(text) {
                return alert(text);
            },
            confirm: function (text, callback) {
                confirm(text) ? callback() : null;
            }
        },
        captions: {
            button: "Choose Files",
            feedback: "Choose files To Upload",
            feedback2: "files were chosen",
            drop: "Drop file here to Upload",
            removeConfirmation: "Are you sure you want to remove this file?",
            errors: {
                filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                filesType: "Only Images are allowed to be uploaded.",
                filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
            }
        }
    });


    // upload form
        $(document).on("click","#add", function() {
            $(".inputcontainer").append('\
                <div class="imageupload">\
                    <span class="file-name"></span>\
                    <div class="row">\
                    <div class="col-md-8">\
                        <input type="text" name="text[]" class="form-control" placeholder="Enter Option..">\
                    </div>\
                    <div class="col-md-4"> \
                        <label class="btn btn-primary btn-file">Choose Photo\
                            <input type="file" name="file[]">\
                        </label>\
                        <button title="remove this field" type="button" class="close remove-field" aria-label="Close">\
                            <span aria-hidden="true">&times;</span>\
                        </button>\
                    </div>\
                    </div>\
                </div>');
        });

        $(document).on("click", ".remove-field", function() {
            $(this).parent().parent().parent().remove();
        });

        $(document).on("change", "input:file", function() {
            $(this).closest('.imageupload').find('.file-name').html('<i class="glyphicon glyphicon-ok-sign text-success"></i> <span class="text-success">'+$(this)[0].files[0].name+"</span>");
        });


//swipebox
$( '.swipebox' ).swipebox();

});

function goto() {
                var location = window.location.pathname;
                if(location == "/index.php" || location == "/index.php") {
                  $("html, body").animate({ scrollTop: $("#create").offset().top - 80 }, 1000);
                }
                else
                  window.location = 'index.php';
              }