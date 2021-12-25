# Frontify colors

DB configuration: inc/config.php
Start dev server `php -S 127.0.0.1:9000`
Access http://127.0.0.1:9000/frontend/index.html

Api entry point: api/index.php

Return all colors:
GET /api/colors

Return a specific color:
GET /api/colors/{id}

Create a new color:
POST /api/colors

Delete an existing color:
DELETE /api/colors/{id}
