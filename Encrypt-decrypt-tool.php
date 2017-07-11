<?php
/*
Plugin Name: Encrypt Decrypt Tool
Plugin URI: http://eresdev.com/tools/encrypt-decrypt
Description: A wordpress plugin to add a tool to encrypt/decrypt
Version: 1.0
Author: EresDev
Author URI: http://eresdev.com
License: GPL2
*/

function encrypt_decrypt_tool_html(){
    ?>
<form name="encrypt_decrypt_tool" method="post">
    <label>Choose a method:<br><select name="method" required>
        <?php
        $ciphers = openssl_get_cipher_methods();
        foreach($ciphers as $i=>$cipher) { ?>
        <option value="<?php echo $i; ?>"><b style="font-weight:bold;">OpenSSL</b> <?php echo $cipher; ?></option>
            <?php } ?>
    </select></label><br>
    <label>Insert your key:<br>
        <input type="password" name="key" id="key" required pattern=".*\S+.*" title="This field is required"></label>
    <label>Confirm your key:<br>
        <input type="password" name="key_confirm" oninput="check(this)" required pattern=".*\S+.*" title="This field is required"></label>
    <label>Insert text to Encrypt/Decrypt:<br>
        <textarea name="main_text" required pattern=".*\S+.*" title="This field is required"></textarea></label>
    <div class="btn-container">
    <input type="submit" name="encrypt" value="Encrypt"> OR
    <input type="submit" name="decrypt" value="Decrypt">
    </div>
</form>
    <script type="text/javascript">
        function check(input) {
            if (input.value != document.getElementById('key').value) {
                input.setCustomValidity('Confirm must be matching to the key.');
            } else {
                // input is valid -- reset the error message
                input.setCustomValidity('');
            }
        }

    </script>
    <style type="text/css">
        label{
            display:block;
        }
        p.post-date{
            display:none;
        }
        select, input[type=password], textarea{
            width: 100%;
            border: 1px solid #000;
            padding: 0 10px;
            font-family: Arial;
        }
        textarea{
            height: 300px;
            font-family: Arial;
            font-size: 12px;
        }
        input[type=submit]{
            width: 40%;
        }
        div.btn-container{
            text-align: center;
        }
    </style>
<?php
}
add_shortcode("encrypt_decrypt_tool", "encrypt_decrypt_tool_html");