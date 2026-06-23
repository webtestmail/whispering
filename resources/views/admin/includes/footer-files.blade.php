<!--! ================================================================ !-->
<!--! [End] Theme Customizer !-->
<!--! ================================================================ !-->
<!--! ================================================================ !-->
<!--! Footer Script !-->
<!--! ================================================================ !-->
<!--! BEGIN: Vendors JS !-->
<script src="{{ asset('backend/assets/vendors/js/vendors.min.js') }}"></script>
<!-- vendors.min.js {always must need to be top} -->
<script src="{{ asset('backend/assets/vendors/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendors/js/select2.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendors/js/select2-active.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendors/js/lslstrength.min.js') }}"></script>
<!--! END: Vendors JS !-->
<!--! BEGIN: Apps Init  !-->
<script src="{{ asset('backend/assets/js/common-init.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/dashboard-init.min.js') }}"></script>
{{-- <script src="{{ asset('backend/assets/js/customers-create-init.min.js') }}"></script> --}}
<!--! END: Apps Init !-->
<!--! BEGIN: Theme Customizer  !-->
<script src="{{ asset('backend/assets/js/theme-customizer-init.min.js') }}"></script>
<!--! END: Theme Customizer !-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- TinyMCE -->
<script src="{{ asset('backend/assets/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'a11ychecker advcode advlist advtable anchor autocorrect autolink autoresize autosave casechange charmap checklist code codesample directionality editimage emoticons export footnotes formatpainter fullscreen help image importcss inlinecss insertdatetime link linkchecker lists media mediaembed mentions mergetags nonbreaking pagebreak pageembed permanentpen powerpaste preview quickbars save searchreplace table tableofcontents template tinycomments tinydrive tinymcespellchecker typography visualblocks visualchars wordcount',
        toolbar: 'undo redo | blocks| bold italic | bullist numlist checklist | code | table | alignleft aligncenter alignright alignjustify | outdent indent | wordcount | a11ycheck advtablerownumbering typography anchor restoredraft casechange charmap checklist code codesample addcomment showcomments ltr rtl editimage fliph flipv imageoptions rotateleft rotateright emoticons export footnotes footnotesupdate formatpainter fullscreen help image insertdatetime link openlink unlink bullist numlist media mergetags mergetags_list nonbreaking pagebreak pageembed permanentpen preview quickimage quicklink quicktable cancel save searchreplace spellcheckdialog spellchecker',
        resize: 'both',
        extended_valid_elements: 'span[*]'  // Add this line to preserve span tags
    });
</script>

@stack('page-wise-js')
