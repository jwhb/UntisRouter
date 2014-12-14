        <?php 
        $has_comments = (isset($other_user['comments']) && sizeof($other_user['comments']) != 0);
        
        if(!isset($other_user['first_name'])): ?>
            <p>Der gew&uuml;nschte Benutzer wurde nicht gefunden.</p>
        <?php else:
            echo form_open('profile/add_comment', array('class' => 'pure-form pure-form-stacked user_comment_add_box')); ?> 
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
                <div style="text-align: center;">
                    <?php echo form_submit(array('class' => 'pure-button pure-button-primary', 'name' => 'add-comment', 'value' => 'absenden' )); ?> 
                    <?php echo form_checkbox(array('name' => 'hidden', 'value' => 'hidden', 'style' => 'margin-left: 1em;')); ?> 
                    <?php echo form_label('<i class="fa fa-eye-slash"></i> anonym', 'hidden', array('style' => 'display: inline')); ?> 
                </div>
            <?php echo form_fieldset_close(); ?> 
        <?php echo form_close();             
            if(!$has_comments): ?>
            <p>(noch) keine Kommentare vorhanden</p>
        <?php else: ?>       
        <hr style="margin-bottom: 2em;" />
        
        <?php foreach($other_user['comments'] as $comment): ?>
        <table class="pure-table pure-table-bordered user_comment_single">
          <tbody>
            <tr class="user_comment_single_header">
                <td style="border-right-width: 0px;"><?php if(!$comment->hidden): $name = $comment->username_from; echo anchor("profile/view/$name", $name); else: 
                  ?> <i class="fa fa-eye-slash"></i> anonym<?php if($user['is_mod']) echo ' (' . $comment->username_from . ')'; endif; ?></td>
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
        </table><?php endforeach; endif; endif; ?> 
