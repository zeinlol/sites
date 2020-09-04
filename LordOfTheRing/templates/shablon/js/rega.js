    function check_str ( value )
    {
      var regxp     = new RegExp("[||!@#$%^&*+();><`]");
         if ( value.match(regxp) )
         {
           return true;
         }
         else
         {
         var reg = new RegExp("[0-9a-zA-ZÀ-ß_^.]", 'i');
         return !reg.test( value );
         }
    }

    function check_login ( obj )
    {
        var value = obj.value;
        if ( value == '' )
        {
              document.getElementById('result-registration').innerHTML = '<div style="color:red;font-size:11px">Логин не может быть пустым</div>';
        }
        else if ( value.length < 3 )
        {
             document.getElementById('result-registration').innerHTML = '<div style="color:red;font-size:11px">Указан слишком короткий логин</div>';
        }
        else if ( value.length > 15 )
        {
             document.getElementById('result-registration').innerHTML = '<div style="color:red;font-size:11px">Указан слишком длинный логин</div>';
        }
        else if ( check_str( value ))
        {
             document.getElementById('result-registration').innerHTML = '<div style="color:red;font-size:11px">Логин содержит запрещённые символы</div>';
        }
        else
        {
            CheckLogin();
        }
    }

    function check_first ( obj )
    {
           var value = obj.value;

           if ( value.length < 6 )
           {
                document.getElementById('result-first').innerHTML = '<div style="color:red;font-size:11px">Указан слишком короткий пароль</div>';
           }
           else
           {
                document.getElementById('result-first').innerHTML = '<div style="color:green;font-size:11px"><!--ОК--></div>';
           }
    }

     function check_password ()
     {
          var pass1 = document.getElementById('password1').value;
          var pass2 = document.getElementById('password2').value;

        if ( pass1 != '' && pass2 != '' )
        {
              if ( pass1 != pass2 )
              {
                   document.getElementById('result-pass').innerHTML = '<div style=\"color:red;font-size:11px\">Введённые вами пароли не совпадают</div><br />';
              }
              else
              {
                 document.getElementById('result-pass').innerHTML = '<div style="color:green;font-size:11px"><!--ОК--></div>';
              }
          }
     }

     function check_mail ( obj )
    {
        var value = obj.value;

          var reg = new  RegExp("[0-9a-z_]+@[0-9a-z_^.]+\\.[a-z]", 'i');
        if ( !reg.test ( value ))
        {
            document.getElementById('result-mail').innerHTML = '<div style=\"color:red;font-size:11px\" >Указан неверный адрес электронной почты</div>';
        }
        else
        {
            document.getElementById('result-mail').innerHTML = '<div style="color:green;font-size:11px"><!--ОК--></div>';
        }
    }