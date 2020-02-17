function showDiv(id) {
    for (var i = 0; i < document.getElementById("wrap_text").getElementsByTagName("div").length; i++) {
        var div = document.getElementById("wrap_text").getElementsByTagName("div")[i];
        var wrapImg = document.getElementById("wrap").getElementById("sub_wrap").getElementsByTagName("div")[i + 10];
        if (div.id == id) {
            div.style.display = "block";
            wrapImg.classList.add("active_box");
        } else {
            div.style.display = "none";
            wrapImg.classList.remove("active_box");
        }
    }
}






