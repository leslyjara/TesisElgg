$(document).ready(function() {
    $(".optionQuestions").hide();
    $(".optionGeneral").show();
    $(".optionRC").hide();
});

$(".questions" ).click(function() {
    $(".optionQuestions").toggle();
});
$(".general" ).click(function() {
    $(".optionGeneral").toggle();
})
$(".RC" ).click(function() {
    $(".optionRC").toggle();
})