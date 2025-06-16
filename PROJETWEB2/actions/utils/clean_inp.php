<?php
function Clean_input($val)
{
    return filter_var(strip_tags(htmlspecialchars(trim($val))), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}
?>