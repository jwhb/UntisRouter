<?php
if(!isset($other_user['first_name'])): ?>
Der gew&uuml;nschte Benutzer wurde nicht gefunden.
<?php else: if(!isset($other_user['comments']) || sizeof($other_user['comments'] == 0)): ?>
    <p>(noch) keine Kommentare vorhanden</p>
<?php else: foreach($other_user['comments'] as $comment): ?>
    <div style="border: 1px solid blue; width: 20em; margin: 1em; padding: 0.5em;">
        From <?php print($comment->id); ?><br />
        <?php
            $date = new DateTime();
            $date->setTimestamp($comment->time);
            print($date->format("d.m.Y, t"));
        ?>
        <hr />
        <div style="font-size: 1.3em;"><?php print($comment->text); ?></div>
    </div>
<?php endforeach; endif; ?>

<hr />
<?php echo form_open('profile/add_comment', array('class' => 'pure-form pure-form-stacked')); ?> 
    <?php echo form_fieldset(); ?> 
        <legend>Neuen Kommentar schreiben</legend>

        <?php echo form_textarea(array(
            'name' => 'comment',
            'id' => 'comment',
            'placeholder' => 'Welche Assoziationen fallen dir zu ' . $other_user['first_name'] . ' ein?',
            'cols' => '50',
            'rows' => '2',
            'maxlength' => '400'
        )); ?> 
        <?php echo form_submit(array('class' => 'pure-button pure-button-primary', 'name' => 'add-comment', 'value' => 'absenden' )); ?> 
    <?php echo form_fieldset_close(); ?> 
</form>
<?php endif; ?>
