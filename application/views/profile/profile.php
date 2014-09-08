<form class="pure-form pure-form-stacked">
  <fieldset>
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3">

        <label for="first_name">First Name</label>
        <input id="first_name" type="text" placeholder="First Name" value="<?php echo $user['first_name'] ?>">

        <label for="last_name">Last Name</label>
        <input id="last_name" type="text" placeholder="Last Name" value="<?php echo $user['last_name'] ?>">

        <button type="submit" style="display: none;" class="pure-button pure-button-primary">Sign in</button>
    </div>
  </fieldset>
</form>
