<script src="https://cdn.ckbox.io/ckbox/2.4.0/ckbox.js"></script>

        <script type="importmap">
            {
                "imports": {
                    "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
                    "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/",
                    "ckeditor5-premium-features": "https://cdn.ckeditor.com/ckeditor5-premium-features/42.0.0/ckeditor5-premium-features.js",
                    "ckeditor5-premium-features/": "https://cdn.ckeditor.com/ckeditor5-premium-features/42.0.0/"
                }
            }
        </script>
        <script type="module">
            // This sample still does not showcase all CKEditor 5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            import {
                ClassicEditor,
                Autoformat,
                Bold,
                Italic,
                Underline,
                BlockQuote,
                Base64UploadAdapter,
                CloudServices,
                CKBox,
                CKBoxImageEdit,
                Essentials,
                FindAndReplace,
                Font,
                Heading,
                Image,
                ImageCaption,
                ImageResize,
                ImageStyle,
                ImageToolbar,
                ImageUpload,
                PictureEditing,
                Indent,
                IndentBlock,
                Link,
                List,
                MediaEmbed,
                Mention,
                Paragraph,
                PasteFromOffice,
                SourceEditing,
                Table,
                TableColumnResize,
                TableToolbar,
                TextTransformation,
                HtmlEmbed,
                CodeBlock,
                RemoveFormat,
                Code,
                SpecialCharacters,
                HorizontalLine,
                PageBreak,
                TodoList,
                Strikethrough,
                Subscript,
                Superscript,
                Highlight,
                Alignment
            } from 'ckeditor5';

            import {
                ExportPdf,
                ExportWord
            } from 'ckeditor5-premium-features';

            document.querySelectorAll('#short_description, #description').forEach( editorElement => {
                ClassicEditor.create( ( editorElement ), {
                    plugins: [
                        Autoformat,
                        BlockQuote,
                        Bold,
                        CloudServices,
                        CKBox,
                        Essentials,
                        FindAndReplace,
                        Font,
                        Heading,
                        Image,
                        ImageCaption,
                        ImageResize,
                        ImageStyle,
                        ImageToolbar,
                        ImageUpload,
                        Base64UploadAdapter,
                        Indent,
                        IndentBlock,
                        Italic,
                        Link,
                        List,
                        MediaEmbed,
                        Mention,
                        Paragraph,
                        PasteFromOffice,
                        PictureEditing,
                        SourceEditing,
                        Table,
                        TableColumnResize,
                        TableToolbar,
                        TextTransformation,
                        Underline,
                        HtmlEmbed,
                        CodeBlock,
                        RemoveFormat,
                        Code,
                        SpecialCharacters,
                        HorizontalLine,
                        PageBreak,
                        TodoList,
                        Strikethrough,
                        Subscript,
                        Superscript,
                        Highlight,
                        Alignment,
                        CKBoxImageEdit,
                        ExportPdf,
                        ExportWord
                    ],
                    toolbar: {
                        items: [
                            'undo', 'redo',
                            '|',
                            'sourceEditing',
                            '|',
                            'exportPDF','exportWord',
                            '|',
                            'findAndReplace', 'selectAll',
                            '|',
                            'heading',
                            '|',
                            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor',
                            '-',
                            'bold', 'italic', 'underline',
                            {
                                label: 'Formatting',
                                icon: 'text',
                                items: [ 'strikethrough', 'subscript', 'superscript', 'code', '|', 'removeFormat' ]
                            },
                            '|',
                            'specialCharacters', 'horizontalLine', 'pageBreak',
                            '|',
                            'link', 'insertImage', 'ckbox', 'ckboxImageEdit', 'insertTable',
                            {
                                label: 'Insert',
                                icon: 'plus',
                                items: [ 'highlight', 'blockQuote', 'mediaEmbed', 'codeBlock', 'htmlEmbed' ]
                            },
                            'alignment',
                            '|',
                            'bulletedList', 'numberedList', 'todoList',
                            {
                                label: 'Indents',
                                icon: 'plus',
                                items: [ 'outdent', 'indent' ]
                            }
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    list: {
                        properties: {
                            styles: true,
                            startIndex: true,
                            reversed: true
                        }
                    },
                    // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                            { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                        ]
                    },
                    placeholder: 'Welcome to CKEditor 5 + CKBox!',
                    image: {
                        resizeOptions: [
                            {
                                name: 'resizeImage:original',
                                label: 'Default image width',
                                value: null
                            },
                            {
                                name: 'resizeImage:50',
                                label: '50% page width',
                                value: '50'
                            },
                            {
                                name: 'resizeImage:75',
                                label: '75% page width',
                                value: '75'
                            }
                        ],
                        toolbar: [
                            'imageTextAlternative',
                            'toggleImageCaption',
                            '|',
                            'imageStyle:inline',
                            'imageStyle:wrapText',
                            'imageStyle:breakText',
                            '|',
                            'resizeImage'
                        ],
                    },
                    link: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://'
                    },
                    table: {
                        contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ],
                    },
                    ckbox: {
                        // You need to provide your own token endpoint here
                        // Sign up to CKBox to get one: https://ckeditor.com/ckbox/
                        tokenUrl: 'https://api.ckbox.io/token/demo',
                        theme: 'lark'
                    }
                } )
                .then( ( editor ) => {
                    window.editor = editor;
                } )
                .catch( ( error ) => {
                    console.error( error.stack );
                } );
            } );

        </script>

        <!-- Core JS -->

        <!-- build:js assets/vendor/js/core.js -->

        <script src="{{ asset('admin-assets/assets/vendor/libs/jquery/jquery.js') }}"></script>

        <script src="{{ asset('admin-assets/assets/vendor/libs/popper/popper.js') }}"></script>

        <script src="{{ asset('admin-assets/assets/vendor/js/bootstrap.js') }}"></script>

        <script src="{{ asset('admin-assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>



        <script src="{{ asset('admin-assets/assets/vendor/js/menu.js') }}"></script>

        <!-- endbuild -->



        <!-- Vendors JS -->

        <script src="{{ asset('admin-assets/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>



        <!-- Sweet Alert 2 -->

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



        <!-- Main JS -->

        <script src="{{ asset('admin-assets/assets/js/main.js') }}"></script>



        <!-- Page JS -->

        <script src="{{ asset('admin-assets/assets/js/dashboards-analytics.js') }}"></script>

        <script src="{{ asset('admin-assets/assets/js/pages-account-settings-account.js') }}"></script>



        <!-- Place this tag in your head or just before your close body tag. -->

        <script async defer src="https://buttons.github.io/buttons.js"></script>



        <!-- TinyMCE -->

        <script src="{{ asset('admin-assets/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
        {{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> --}}

        {{-- 
        <script>

            ClassicEditor
                .create(document.querySelector('#editor'), {
                    
                    ckfinder: {
                    uploadUrl:"{{ route('upload.blog_images').'?_token='.csrf_token() }}"
                    }
                })
                .then(editor => {
                    console.log('Editor was initialized', editor);
                })
                .catch(error => {
                    console.error('There was a problem initializing the editor.', error);
                });
        </script>
        --}}

        <script>

            tinymce.init({

                selector: 'textarea#meta_description', // Replace this CSS selector to match the placeholder element for TinyMCE

                // selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE

                plugins: 'image a11ychecker advcode advlist advtable anchor autocorrect autolink autoresize autosave casechange charmap checklist code codesample directionality editimage emoticons export footnotes formatpainter fullscreen help importcss inlinecss insertdatetime link linkchecker lists media mediaembed mentions mergetags nonbreaking pagebreak pageembed permanentpen powerpaste preview quickbars save searchreplace table tableofcontents template tinycomments tinydrive tinymcespellchecker typography visualblocks visualchars wordcount',

                toolbar: 'undo redo | link image | blocks | bold italic | bullist numlist checklist | code | table | alignleft aligncenter alignright alignjustify | outdent indent | wordcount | a11ycheck advtablerownumbering typopgraphy anchor restoredraft casechange charmap checklist code codesample addcomment showcomments ltr rtl editimage fliph flipv imageoptions rotateleft rotateright emoticons export footnotes footnotesupdate formatpainter fullscreen help image insertdatetime link openlink unlink bullist numlist media mergetags mergetags_list nonbreaking pagebreak pageembed permanentpen preview quickimage quicklink quicktable cancel save searchreplace spellcheckdialog spellchecker',

            });

        </script>

    </body>

</html>
