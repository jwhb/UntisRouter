<?php if(!isset($other_user['first_name'])): ?>
    <p>Der gew&uuml;nschte Benutzer wurde nicht gefunden.</p>
<?php elseif(!isset($other_user['comments']) || sizeof($other_user['comments']) == 0): ?>
    <p>(noch) keine Kommentare vorhanden</p>
<?php else: echo form_open('profile/add_comment', array('class' => 'pure-form pure-form-stacked user_comment_add_box')); ?> 
    <?php echo form_fieldset(); ?> 
        <legend>Assoziation hinzuf&uuml;gen</legend>

        <?php echo form_textarea(array(
            'name' => 'comment',
            'id' => 'comment',
            'placeholder' => 'Welche Assoziationen fallen dir zu ' . $other_user['first_name'] . ' ein?',
            'cols' => '50',
            'rows' => '2',
            'maxlength' => '400'
        )); ?> 
        <?php echo form_hidden('for_user', $other_user['id']); ?> 
        <?php echo form_submit(array('class' => 'pure-button pure-button-primary', 'name' => 'add-comment', 'value' => 'absenden' )); ?> 
    <?php echo form_fieldset_close(); ?> 
<?php echo form_close(); ?> 
<hr style="margin-bottom: 2em;" />
<?php foreach($other_user['comments'] as $comment): ?>
    <table class="pure-table pure-table-bordered user_comment_single">
      <tbody>
        <tr class="user_comment_single_header">
            <td style="border-right-width: 0px;"><?php $name = $comment->username_from; echo anchor("profile/view/$name", $name); ?></td>
            <td style="border-left-width: 0px;" align="right"><?php
                $date = new DateTime();
                $date->setTimestamp($comment->time);
                print($date->format("d.m.Y, H:i"));
            ?></td>
        </tr>
        <tr class="user_comment_single_body">
            <td colspan="2">
                <?php print($comment->text); ?><?php if($user['id'] == $comment->user_from_id || @$user['is_mod']): ?> 
                <div class="user_comment_single_delete"><?php $c_id = $comment->id; echo anchor("profile/delete_comment/$c_id", 'entfernen', array('class' => 'pure-button')); ?></div><?php endif; ?>
            </td>
        </tr>
      </tbody>
    </table>
<?php endforeach; endif; ?> 
