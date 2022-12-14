function subContent(element, numChar) {
  $(element).each(function () {
    if ($(this).text().length > numChar) {
      $(this).text($(this).text().substr(0, numChar));
      $(this).append("...");
    }
  });
}
