<?php if(!isset($other_user['comments']) || sizeof($other_user['comments'] == 0)): ?>
    <p>Keine Kommentare</p>
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
<?php endforeach; endif;?>
