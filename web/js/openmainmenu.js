$(document).ready(function () {
function find(array, value) {
  for (var i = 0; i < array.length; i++) {
    if (array[i] == value) return i;
  }
  return -1;
};
var Url = location.href;
var UrlArr=Url.split('/');

if(find(UrlArr,'blog')>0){
$('#ClickMeBlog').click();};

if(find(UrlArr,'boutique')>0){
$('#ClickMeBoutique').click();};

});