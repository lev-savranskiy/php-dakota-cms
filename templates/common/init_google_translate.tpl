<?

$pageLanguage = 'ru';
$includedLanguages = 'en,de,fr';


if (LANG =='english'){
$pageLanguage = 'en';
$includedLanguages = 'ru,de,fr';
}
if (LANG =='deutsch'){
$pageLanguage = 'de';
$includedLanguages = 'ru,en,fr';
}
if (LANG =='french'){
$pageLanguage = 'fr';
$includedLanguages = 'ru,en,de';
}
?>


<span id="google_translate_element" class="right"></span>
<script>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: "<?= $pageLanguage ?>",
    includedLanguages: "<?= $includedLanguages ?>",
    autoDisplay: false,
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
  }, 'google_translate_element');
}
</script>
<script src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<div class="clear"></div>
