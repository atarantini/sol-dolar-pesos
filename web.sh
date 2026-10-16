#!/usr/bin/env bash
# Sirve index.html con el servidor embebido de PHP en todas las interfaces.
# Uso: ./web.sh [puerto]   (por defecto 8080)
cd "$(dirname "$0")" || exit 1
PORT="${1:-8899}"
echo "Sirviendo en http://0.0.0.0:${PORT}"
exec php -S "0.0.0.0:${PORT}" -t . router.php
