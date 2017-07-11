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
    $error = false;
    $msgs = array();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $method = intval($_POST['method']);
        $key = $_POST['key'];
        $key_confirm = $_POST['key_confirm'];
        $main_text = $_POST['main_text'];

        //check for errors
        if(str_replace(' ', '', $key) == ""){
            $error = true;
            $msgs[] = "Key cannot be empty.";
        }
        if($key != $key_confirm){
            $error = true;
            $msgs[] = "Key and Confirm Key do not match.";
        }

        if(str_replace(' ', '', $main_text) == ""){
            $error = true;
            $msgs[] = "You have not provided text to encrypt/decrypt.";
        }

        if(!$error){
            $ciphers = openssl_get_cipher_methods();

            echo "<pre>";
            if (isset($_POST['encrypt'])) {
                echo openssl_encrypt($main_text,$ciphers[$method],$key);
            }
            elseif (isset($_POST['decrypt'])) {
                echo openssl_decrypt($main_text,$ciphers[$method],$key);
            }
            echo "</pre>";
        }
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $error) {
        if($error){
           foreach($msgs as $msg){
               echo "<p class='error'><b>ERROR:</b> $msg</p>";
           }
        }
        ?>
        <form name="encrypt_decrypt_tool" method="post">
            <label>Choose an encryption/decryption method:<br><select name="method" required>
                    <?php
                    $ciphers = openssl_get_cipher_methods();
                    foreach ($ciphers as $i => $cipher) { ?>
                        <option value="<?php echo $i; ?>"><b
                                style="font-weight:bold;">OpenSSL</b> <?php echo $cipher; ?></option>
                    <?php } ?>
                </select></label>
            <label>Insert your key:<br>
                <input type="password" name="key" id="key" required pattern=".*\S+.*"
                       title="This field is required"></label>
            <label>Confirm your key:<br>
                <input type="password" name="key_confirm" oninput="check(this)" required pattern=".*\S+.*"
                       title="This field is required"></label>
            <label>Insert text to Encrypt/Decrypt:<br>
                <textarea name="main_text" required pattern=".*\S+.*" title="This field is required"><?php echo $_REQUEST['main_text']; ?></textarea></label>
            <div class="btn-container">
                <input type="submit" name="encrypt" value="Encrypt">
                <input type="submit" name="decrypt" value="Decrypt">
            </div>
        </form>
        <?php
    }

    ?>
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
        label {
            display: block;
        }

        p.post-date {
            display: none;
        }

        select, input[type=password], textarea[name=main_text] {
            width: 100%;
            border: 1px solid #5d5d5d;
            padding: 0 10px;
            font-family: Arial;
            border-radius: 0;
        }

        textarea[name=main_text] {
            height: 300px;
            font-family: Arial;
            font-size: 12px;
        }

        input[type=submit] {
            width: 40%;
        }

        div.btn-container {
            text-align: center;
        }

        form {
            margin-bottom: 100px;
        }
        p.error{
            color: red;
        }
        pre{
            background:#ccc;
            padding: 10px;
        }
    </style>
    <?php
}

add_shortcode("encrypt_decrypt_tool", "encrypt_decrypt_tool_html");