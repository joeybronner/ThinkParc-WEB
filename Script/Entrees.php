<?php

require_once('connexion.php'); 
include('./maclasse.php');
include('./MySQLExeption.php');

session_start();

?>

<html>
<head>
<script>
$(function () {
    $('#btnAdd').click(function () {
        var num     = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // the numeric ID of the new input field being added
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
    // manipulate the name/id values of the input inside the new element
        // H2 - section
        newElem.find('.heading-reference').attr('id', 'ID' + newNum + '_reference').attr('name', 'ID' + newNum + '_reference').html('Entry #' + newNum);
 
        // Title - select
        newElem.find('.label_ttl').attr('for', 'ID' + newNum + '_title');
        newElem.find('.select_ttl').attr('id', 'ID' + newNum + '_title').attr('name', 'ID' + newNum + '_title').val('');
 
        // First name - text
        newElem.find('.label_fn').attr('for', 'ID' + newNum + '_first_name');
        newElem.find('.input_fn').attr('id', 'ID' + newNum + '_first_name').attr('name', 'ID' + newNum + '_first_name').val('');
 
        // Last name - text
        newElem.find('.label_ln').attr('for', 'ID' + newNum + '_last_name');
        newElem.find('.input_ln').attr('id', 'ID' + newNum + '_last_name').attr('name', 'ID' + newNum + '_last_name').val('');
 
        // Color - checkbox
        newElem.find('.label_checkboxitem').attr('for', 'ID' + newNum + '_checkboxitem');
        newElem.find('.input_checkboxitem').attr('id', 'ID' + newNum + '_checkboxitem').attr('name', 'ID' + newNum + '_checkboxitem').val([]);
 
        // Skate - radio
        newElem.find('.label_radio').attr('for', 'ID' + newNum + '_radioitem');
        newElem.find('.input_radio').attr('id', 'ID' + newNum + '_radioitem').attr('name', 'ID' + newNum + '_radioitem').val([]);
 
        // Email - text
        newElem.find('.label_email').attr('for', 'ID' + newNum + '_email_address');
        newElem.find('.input_email').attr('id', 'ID' + newNum + '_email_address').attr('name', 'ID' + newNum + '_email_address').val('');
 
    // insert the new element after the last "duplicatable" input field
        $('#entry' + num).after(newElem);
        $('#ID' + newNum + '_title').focus();
 
    // enable the "remove" button
        $('#btnDel').attr('disabled', false);
 
    // right now you can only add 5 sections. change '5' below to the max number of times the form can be duplicated
        if (newNum == 5)
        $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
    });
 
    $('#btnDel').click(function () {
    // confirmation
        if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
            {
                var num = $('.clonedInput').length;
                // how many "duplicatable" input fields we currently have
                $('#entry' + num).slideUp('slow', function () {$(this).remove(); 
                // if only one element remains, disable the "remove" button
                    if (num -1 === 1)
                $('#btnDel').attr('disabled', true);
                // enable the "add" button
                $('#btnAdd').attr('disabled', false).prop('value', "add section");});
            }
        return false;
             // remove the last element
 
    // enable the "add" button
        $('#btnAdd').attr('disabled', false);
    });
 
    $('#btnDel').attr('disabled', true);
 
});
</script>
</head>

<body>

<center>

<form action="#" method="post" id="sign-up_area">
            <div id="entry1" class="clonedInput">
                <h2 id="reference" name="reference" class="heading-reference">Entry #1</h2>
                <fieldset>
                    <label class="label_ttl" for="title">Title:</label>
                    <select class="select_ttl" name="title" id="title">
                            <option value="" selected="selected" disabled="disabled">
                                Select your title
                            </option>
 
                            <option value="Dr.">
                                Dr.
                            </option>
 
                            <option value="Mr.">
                                Mr.
                            </option>
 
                            <option value="Mrs.">
                                Mrs.
                            </option>
 
                            <option value="Ms.">
                                Ms.
                            </option>
                        </select><!-- end .select_ttl -->
                </fieldset>
 
                <fieldset>
                    <label class="label_fn" for="first_name">First name:</label>
 
                    <input class="input_fn" type="text" name="first_name" id="first_name" value="">
 
                        <p class="form-help">This is help text under the form field.</p><!-- this is optional -->
                </fieldset>
 
                <fieldset>
                    <label class="label_ln" for="last_name">Last name:</label>
                    <input class="input_ln" type="text" name="last_name" id="last_name" value="">
                </fieldset>
 
                <fieldset class="checkbox entrylist">
                    <label class="label_checkboxitem" for="checkboxitemitem">What color?</label>
                    <ul>
                        <li><label><input type="checkbox" id="colorBlue" value="colorBlue" name="checkboxitem" class="input_checkboxitem"> Blue</label></li>
                        <li><label><input type="checkbox" id="colorRed" value="colorRed" name="checkboxitem" class="input_checkboxitem"> Red</label></li>
                        <li><label><input type="checkbox" id="colorWhite" value="colorWhite" name="checkboxitem" class="input_checkboxitem"> White</label></li>
                    </ul><!-- end .input_radio -->
                </fieldset>
 
                <fieldset class="radio entrylist">
                    <label class="label_radio" for="radioitem">Do you skate?</label>
                    <ul>
                        <li><label><input type="radio" id="skateyes" value="skateyes" name="radioitem" class="input_radio"> Yes</label></li>
                        <li><label><input type="radio" id="skateno" value="skateno" name="radioitem" class="input_radio"> No</label></li>
                        <li><label><input type="radio" id="skatewish" value="skatewish" name="radioitem" class="input_radio"> I wish</label></li>
                    </ul><!-- end .input_radio -->
                </fieldset>
 
                <fieldset>
                    <label class="label_email" for="email_address">Email:</label>
                    <input class="input_email" type="text" name="email_address" id="email_address" value="" placeholder="like this: billybob@example.com">
                </fieldset>
            </div><!-- end #entry1 -->
 
            <div id="addDelButtons">
                <input type="button" id="btnAdd" value="add section"> <input type="button" id="btnDel" value="remove section above">
            </div>
 
            <fieldset>
                <label for="notes">Notes</label> 
                <textarea id="notes"></textarea>
            </fieldset>
 
            <fieldset class="check">
                <label><input type="checkbox"> I accept the terms of service.</label>
            </fieldset>
 
            <fieldset class="form-actions">
                <input type="submit" value="Submit">
            </fieldset>
        </form>
ver 0.9.3, last updated Mar 3, 2013



</body>
</html>