<?php

function sanitize($value)
{
    return htmlspecialchars(strip_tags($value));
}
