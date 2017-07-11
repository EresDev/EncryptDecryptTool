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
<form name="encrypt_decrypt_tool" action="post">
    <label>Choose a method:<br><select name="method">
        <?php
        $ciphers = openssl_get_cipher_methods();
        foreach($ciphers as $i=>$cipher) { ?>
        <option value="<?php echo $i; ?>"><b style="font-weight:bold;">OpenSSL</b> <?php echo $cipher; ?></option>
            <?php } ?>
    </select></label><br>
    <label>Insert your key:<br>
        <input type="password" name="key"></label>
    <label>Confirm your key:<br>
        <input type="password" name="key_confirm"></label>
    <label>Insert text to Encrypt/Decrypt:<br>
        <textarea name="main_text"></textarea></label>
    <input type="submit" name="encrypt" value="Encrypt">
    <input type="submit" name="decrypt" value="Decrypt">
</form>
<?php
}
add_shortcode("encrypt_decrypt_tool", "encrypt_decrypt_tool_html");