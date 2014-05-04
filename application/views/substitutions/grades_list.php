<?php if(sizeof($grades) == 0): ?>
<p style="text-align: center;">Derzeit gibt es keine anzuzeigenden Vertretungspl&auml;ne.</p>
<?php else:
  $grades_groups = array();
  $not_numeric = array();
  foreach($grades as $grade){
    $prefix = substr($grade, 0, 1);
    if(is_numeric($prefix)){
      $grades_groups["$prefix"][] = $grade;
    }else{
      $not_numeric['x'][] = $grade;
    }
  }
  $grades_groups = array_merge($grades_groups, $not_numeric);

?><div class="pure-g-r grades_list">
  <?php foreach($grades_groups as $groupname=>$group): ?>
    <div class="pure-u-1-<?php echo sizeof($grades_groups); ?> grades_group">
    <?php foreach($group as $grade): ?>
      <a class="pure-button grade_button grade_<?php echo strtolower($grade); ?> grade_g_<?php echo strtolower(substr($grade, 0, 1)); ?>" href="<?php echo $this->config->base_url('grades/' . $grade); ?>"><?php echo $grade; ?></a>
    <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>