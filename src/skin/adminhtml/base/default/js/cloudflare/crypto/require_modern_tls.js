const $ = require ("jquery")
const switchElement = require ("cloudflare/generic/switch")

$(document).on ( "cloudflare.crypto.require_modern_tls.initialize", switchElement.initialize )
$(document).on ( "cloudflare.crypto.require_modern_tls.toggle", switchElement.toggle )
