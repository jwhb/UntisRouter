        <table class="pure-table pure-table-bordered vp_table" >
          <thead>
            <tr>
              <th>Klasse</th>
              <th>Stunde</th>
              <th>Fach</th>
              <th>Raum</th>
              <th>Art</th>
              <th>Lehrer</th>
            </tr>
          </thead>
          <tbody>
        <?php foreach($substitutions as $subst): ?> 
            <tr>
              <td><?php echo $subst->grade; ?></td>
              <td><?php echo $subst->time; ?></td>
              <td><?php echo $subst->class; ?></td>
              <td><?php echo $subst->room; ?></td>
              <td><?php echo $subst->type; ?></td>
              <td><?php echo $subst->teacher; ?></td>
            </tr>
        <?php endforeach; ?>
            </tbody>
        </table>
