// fiveserver.config.js
module.exports = {
    port: 8086,
    root: '/',
    open: '/',
    host: 'localhost',
    proxy: { "/": "https://local.builderreviewsite.com.au" },
    php: '/opt/homebrew/bin/php',
    useLocalIp: true
  }
