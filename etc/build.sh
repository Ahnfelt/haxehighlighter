cp ../CodeHighlighter.hx .
haxe -js CodeHighlighter.js -main CodeHighlighter.hx && haxe -php php -main CodeHighlighter.hx && bash concatenate-php.sh

