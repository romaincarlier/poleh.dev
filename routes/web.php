<?php

// The public site's routes are all owned by the pole-core package (packages/pole-core/routes/web.php),
// including "/" - keeping a stock route here for the same URI made the app boot into either page
// depending on provider registration order, which is not something to depend on.
