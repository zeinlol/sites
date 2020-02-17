
    $(document).ready(function()
    {
        function s4() 
        {
            return Math.floor((1 + Math.random()) * 0x10000)
                       .toString(10)
                       .substring(1);
        };

        $("#gen-dscnt-code").show();
        $("#gen-dscnt-code").click(function()
        {
            var date = new Date();
            var d = date.getDay();
            var m = date.getMonth() + 1;
            var y = date.getFullYear();
            d = d < 10 ? ("0" + d) : "";
            m = m < 10 ? ("0" + m) : "";
            $("#inputCode").val("KIDLOVE-" + y + m + d + "-" + s4() + "-" + s4() + "-" + s4());
            return false;
        });
    });
