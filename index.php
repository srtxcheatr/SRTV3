<?php
// index.php — retired. This used to be a separate, older copy of the
// store page and had drifted out of sync with terminal.css (undefined
// CSS variables like --amber/--border/--panel broke its styling, and it
// was missing the doLogout() function). store.php is the maintained,
// correctly-styled version, so '/' now just forwards there instead of
// keeping two copies in sync.
header('Location: /store.php', true, 302);
exit;
