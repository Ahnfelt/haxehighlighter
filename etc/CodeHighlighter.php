<?php 


class CodeHighlighter {
	public function __construct(){}
	static function main() {
		;
	}
	static function highlight($code, $languageName, $addLineNumbers) {
		return (($addLineNumbers ? CodeHighlighter::lineNumbers($code) : "")) . "<div class=\"code-code\">" . CodeHighlighter::highlightUntil(_CodeHighlighter_Rule::Flat("", new EReg("^\$", "")), $code, $languageName)->html . "</div>";
	}
	static function highlightUntil($stopRule, $code, $languageName) {
		$language = null;
		{
			$_g = 0; $_g1 =& CodeHighlighter::$languages;
			while($_g < count($_g1)) {
				$l = $_g1[$_g];
				++$_g;
				{
					$_g2 = 0; $_g3 =& $l->names;
					while($_g2 < count($_g3)) {
						$n = $_g3[$_g2];
						++$_g2;
						if(strtolower($n) == strtolower($languageName)) $language = $l;
						unset($n);
					}
				}
				unset($_g2); unset($_g3); unset($l); unset($n);
			}
		}
		if($language === null) return php_Boot::__anonymous(array("html" => $code, "rest" => ""));
		$rules =& array_merge(php_Boot::__array($stopRule), $language->rules);
		$html = new StringBuf();
		$tryRule = null;
		$tryRule = php_Boot::__closure(array("_g" => &$_g, "_g1" => &$_g1, "_g2" => &$_g2, "_g3" => &$_g3, "code" => &$code, "html" => &$html, "l" => &$l, "language" => &$language, "languageName" => &$languageName, "n" => &$n, "rules" => &$rules, "stopRule" => &$stopRule, "tryRule" => &$tryRule), "\$rule", "{
			\$__t__ = (\$rule);
			switch(\$__t__->index) {
			case 0:
			\$pattern = \$__t__->params[1]; \$type = \$__t__->params[0];
			{
				if(!\$pattern->match(\$code)) return _CodeHighlighter_Match::\$NotMatched;
				\$s = \$pattern->matched(0);
				if(strlen(\$s) === 0 && \$rule !== \$stopRule) return _CodeHighlighter_Match::\$NotMatched;
				\$html->b .= CodeHighlighter::markup(\$s, \$type);
				\$code = php_Boot::__substr(\$code, strlen(\$s), null);
			}break;
			case 1:
			\$stop = \$__t__->params[2]; \$start = \$__t__->params[1]; \$language1 = \$__t__->params[0];
			{
				\$match = call_user_func_array(\$tryRule, array(\$start));
				\$__t__2 = (\$match);
				switch(\$__t__2->index) {
				case 1:
				{
					\$h = CodeHighlighter::highlightUntil(\$stop, \$code, \$language1);
					\$html->b .= \$h->html;
					\$code = \$h->rest;
				}break;
				default:{
					return \$match;
				}break;
				}
			}break;
			}
			if(\$rule === \$stopRule) return _CodeHighlighter_Match::\$Done;
			return _CodeHighlighter_Match::\$Matched;
		}");
		while(true) {
			$next = false;
			{
				$_g4 = 0;
				while($_g4 < count($rules)) {
					$rule = $rules[$_g4];
					++$_g4;
					$__t__ = (call_user_func_array($tryRule, array($rule)));
					switch($__t__->index) {
					case 0:
					{
						return php_Boot::__anonymous(array("html" => $html->b, "rest" => $code));
					}break;
					case 1:
					{
						$next = true;
					}break;
					case 2:
					{
						;
					}break;
					}
					if($next) break;
					unset($__t__); unset($rule);
				}
			}
			if(!$next) {
				$html->b .= StringTools::htmlEscape(php_Boot::__substr($code, 0, 1));
				$code = php_Boot::__substr($code, 1, null);
			}
			unset($__t__); unset($_g4); unset($next); unset($rule);
		}
		return null;
	}
	static function markup($code, $type) {
		if(strlen($type) === 0) return StringTools::htmlEscape($code);
		return "<span class=\"code-" . $type . "\">" . StringTools::htmlEscape($code) . "</span>";
	}
	static function lineNumbers($code) {
		$ns =& explode("\n", $code);
		$rs =& explode("\r", $code);
		$lines = (count($ns) > count($rs) ? $ns : $rs);
		$count = count($lines);
		$last = array_pop($lines);
		if($last !== null && (strlen($last) === 0 || $last == "\n" || $last == "\r")) {
			$count -= 1;
		}
		$html = new StringBuf();
		$html->b .= "<div class=\"code-line-numbers\" name=\"code-line-numbers\">";
		{
			$_g = 0;
			while($_g < $count) {
				$i = $_g++;
				if($i !== 0) $html->b .= "\n";
				$html->b .= $i + 1;
				unset($i);
			}
		}
		$html->b .= "</div>";
		return $html->b;
	}
	static $patterns;
	static $common;
	static $languages;
}
CodeHighlighter::$patterns = php_Boot::__anonymous(array("ignorable" => new EReg("^[ \\t\\r\\n]+", ""), "doubleString" => new EReg("^([\"]([^\\\\\"]|\\\\.)*[\"])", ""), "singleString" => new EReg("^([']([^'\\\\]|['][']|\\\\.)*['])", ""), "number" => new EReg("^([0-9]+([.][0-9]+)?([eE][+-]?[0-9]+)?)[a-zA-Z]?", ""), "dollarIdentifier" => new EReg("^([\$][a-zA-Z0-9_]*)", ""), "identifier" => new EReg("^([a-zA-Z_][a-zA-Z0-9_]*)", ""), "upperIdentifier" => new EReg("^([A-Z][a-zA-Z0-9_]*)", ""), "lowerIdentifier" => new EReg("^([a-z_][a-zA-Z0-9_]*)", ""), "docCommentBegin" => new EReg("^/\\*\\*", ""), "docCommentEnd" => new EReg("^\\*/", ""), "blockComment" => new EReg("^([/][*]([^*]|[*][^/])*[*][/])", ""), "lineComment" => new EReg("^([/][/][^\\n]*)", ""), "entity" => new EReg("^([&][^;]+[;])", "")));
CodeHighlighter::$common = php_Boot::__anonymous(array("ignorable" => _CodeHighlighter_Rule::Flat("", CodeHighlighter::$patterns->ignorable), "docComment" => _CodeHighlighter_Rule::Nested("doc-comment", _CodeHighlighter_Rule::Flat("comment", CodeHighlighter::$patterns->docCommentBegin), _CodeHighlighter_Rule::Flat("comment", CodeHighlighter::$patterns->docCommentEnd)), "blockComment" => _CodeHighlighter_Rule::Flat("comment", CodeHighlighter::$patterns->blockComment), "lineComment" => _CodeHighlighter_Rule::Flat("comment", CodeHighlighter::$patterns->lineComment), "hashComment" => _CodeHighlighter_Rule::Flat("comment", new EReg("^([#][^\\n\\r]*)", "")), "number" => _CodeHighlighter_Rule::Flat("number", CodeHighlighter::$patterns->number), "doubleString" => _CodeHighlighter_Rule::Flat("string", CodeHighlighter::$patterns->doubleString), "singleString" => _CodeHighlighter_Rule::Flat("string", CodeHighlighter::$patterns->singleString), "functionName" => _CodeHighlighter_Rule::Flat("", new EReg("^([a-zA-Z_][a-zA-Z0-9_]*\\s*[(])", "")), "regex" => _CodeHighlighter_Rule::Flat("string", new EReg("^\\~/([^\\\\/]|\\\\.)*/[a-zA-Z]*", ""))));
CodeHighlighter::$languages = php_Boot::__array(php_Boot::__anonymous(array("names" => php_Boot::__array("xml-attributes"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("type", new EReg("^[a-zA-Z0-9_.-]+", "")), CodeHighlighter::$common->doubleString, CodeHighlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("html", "xhtml", "xml"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("comment", new EReg("^(<[!]--([^-]|[-][^-]|[-][-][^>])*-->)", "")), _CodeHighlighter_Rule::Flat("variable", new EReg("^(<[!]\\[CDATA\\[([^\\]]|\\][^\\]]|\\]\\][^>])*\\]\\]>)", "i")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(<[%]([^%]|[%][^>])*[%]>)", "")), _CodeHighlighter_Rule::Nested("css", _CodeHighlighter_Rule::Nested("xml-attributes", _CodeHighlighter_Rule::Flat("keyword", new EReg("^<\\s*style\\b", "i")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^>", ""))), _CodeHighlighter_Rule::Flat("keyword", new EReg("^<\\s*/\\s*style\\s*>", "i"))), _CodeHighlighter_Rule::Nested("javascript", _CodeHighlighter_Rule::Nested("xml-attributes", _CodeHighlighter_Rule::Flat("keyword", new EReg("^<\\s*script\\b", "i")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^>", ""))), _CodeHighlighter_Rule::Flat("keyword", new EReg("^<\\s*/\\s*script\\s*>", "i"))), _CodeHighlighter_Rule::Nested("php", _CodeHighlighter_Rule::Flat("keyword", new EReg("^<[?](php[0-9]*)?", "i")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^[?]>", ""))), _CodeHighlighter_Rule::Nested("xml-attributes", _CodeHighlighter_Rule::Flat("keyword", new EReg("^<\\s*[a-zA-Z0-9_.-]+", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^>", ""))), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(<\\s*/\\s*[a-zA-Z0-9_.-]+)\\s*(>)", "")), _CodeHighlighter_Rule::Flat("variable", CodeHighlighter::$patterns->entity), _CodeHighlighter_Rule::Flat("", new EReg("^[^<&]+", ""))))), php_Boot::__anonymous(array("names" => php_Boot::__array("css"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("variable", new EReg("^([a-zA-Z-]+[:])", "")), _CodeHighlighter_Rule::Flat("number", new EReg("^([#][0-9a-fA-F]{6}|[0-9]+[a-zA-Z%]*)", "")), _CodeHighlighter_Rule::Flat("type", new EReg("^([#.:]?[a-zA-Z>-][a-zA-Z0-9>-]*)", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(url|rgb|rect|inherit)\\b", "")), _CodeHighlighter_Rule::Flat("comment", new EReg("^(<!--|-->)", "")), CodeHighlighter::$common->blockComment))), php_Boot::__anonymous(array("names" => php_Boot::__array("wikitalis", "wiki"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("keyword", new EReg("^(\\\\[a-zA-Z]+)", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(\\{|\\})", "")), _CodeHighlighter_Rule::Flat("", new EReg("^[^\\\\{}]+", ""))))), php_Boot::__anonymous(array("names" => php_Boot::__array("ebnf", "bnf"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("keyword", new EReg("^(\\:\\:\\=|\\[|\\]|\\{|\\})", "")), _CodeHighlighter_Rule::Flat("type", new EReg("^(<[a-zA-Z0-9 _-]+>)", "")), _CodeHighlighter_Rule::Flat("comment", new EReg("^([?][^?]*[?])", "")), CodeHighlighter::$common->doubleString, _CodeHighlighter_Rule::Flat("string", CodeHighlighter::$patterns->identifier)))), php_Boot::__anonymous(array("names" => php_Boot::__array("doc-comment"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("type", new EReg("^[@][a-zA-Z0-9_-]+", "")), _CodeHighlighter_Rule::Flat("variable", new EReg("^[<]/?[a-zA-Z0-9_.-]+[^>]*[>]", "")), _CodeHighlighter_Rule::Flat("comment", new EReg("^([^@<*\\r\\n]+|.)", ""))))), php_Boot::__anonymous(array("names" => php_Boot::__array("php"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("keyword", new EReg("^(and|or|xor|__FILE__|exception|__LINE__|array|as|break|case|class|const|continue|declare|default|die|do|echo|else|elseif|empty|enddeclare|endfor|endforeach|endif|endswitch|endwhile|eval|exit|extends|for|foreach|function|global|if|include|include_once|isset|list|new|print|require|require_once|return|static|switch|unset|use|var|while|__FUNCTION__|__CLASS__|__METHOD__|final|php_user_filter|interface|implements|instanceof|public|private|protected|abstract|clone|try|catch|throw|cfunction|old_function|this|final|__NAMESPACE__|namespace|goto|__DIR__)\\b", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(<\\?(php[0-9]*)?\\b|\\?>)", "")), CodeHighlighter::$common->functionName, _CodeHighlighter_Rule::Flat("variable", CodeHighlighter::$patterns->dollarIdentifier), CodeHighlighter::$common->docComment, CodeHighlighter::$common->blockComment, CodeHighlighter::$common->lineComment, CodeHighlighter::$common->number, CodeHighlighter::$common->doubleString, CodeHighlighter::$common->singleString, _CodeHighlighter_Rule::Flat("", new EReg("^[a-zA-Z0-9]+", ""))))), php_Boot::__anonymous(array("names" => php_Boot::__array("javascript", "jscript", "js"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("keyword", new EReg("^(abstract|boolean|break|byte|case|catch|char|class|const|continue|debugger|default|delete|do|double)\\b", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(else|enum|export|extends|false|final|finally|float|for|function|goto|if|implements|import|in)\\b", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(instanceof|int|interface|long|native|new|null|package|private|protected|public|return|short|static|super)\\b", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(switch|synchronized|this|throw|throws|transient|true|try|typeof|var|void|volatile|while|with)\\b", "")), _CodeHighlighter_Rule::Flat("type", CodeHighlighter::$patterns->entity), CodeHighlighter::$common->functionName, _CodeHighlighter_Rule::Flat("variable", new EReg("^[a-zA-Z_\$][a-zA-Z0-9_]*", "")), _CodeHighlighter_Rule::Flat("comment", new EReg("^(<!--|-->)", "")), CodeHighlighter::$common->docComment, CodeHighlighter::$common->blockComment, CodeHighlighter::$common->lineComment, CodeHighlighter::$common->number, CodeHighlighter::$common->doubleString, CodeHighlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("perl"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("string", new EReg("^(m|q|qq|qw|qx)/([^\\\\/]|\\\\.)*/[a-zA-Z]*", "")), _CodeHighlighter_Rule::Flat("string", new EReg("^(y|tr|s)/([^\\\\/]|\\\\.)*/([^\\\\/]|\\\\.)*/[a-zA-Z]*", "")), _CodeHighlighter_Rule::Flat("string", new EReg("^/(([^\\s/\\\\]|\\\\.)([^\\\\/]|\\\\.)*)?/[a-zA-Z]*", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(abs|accept|alarm|Answer|Ask|atan2|bind|binmode|bless|caller|chdir|chmod|chomp|Choose|chop|chown|chr|chroot|close|closedir|connect|continue|cos|crypt|dbmclose|dbmopen|defined|delete|die|Directory|do|DoAppleScript|dump)\\b", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(each|else|elsif|endgrent|endhostent|endnetent|endprotoent|endpwent|eof|eval|exec|exists|exit|exp|FAccess|fcntl|fileno|find|flock|for|foreach|fork|format|formline)\\b", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(getc|GetFileInfo|getgrent|getgrgid|getgrnam|gethostbyaddr|gethostbyname|gethostent|getlogin|getnetbyaddr|getnetbyname|getnetent|getpeername|getpgrp|getppid|getpriority|getprotobyname|getprotobynumber|getprotoent|getpwent|getpwnam|getpwuid|getservbyaddr|getservbyname|getservbyport|getservent|getsockname|getsockopt|glob|gmtime|goto|grep)\\b", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(hex|hostname|if|import|index|int|ioctl|join|keys|kill|last|lc|lcfirst|length|link|listen|LoadExternals|local|localtime|log|lstat|MakeFSSpec|MakePath|map|mkdir|msgctl|msgget|msgrcv|msgsnd|my|next|no|oct|open|opendir|ord)\\b", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(pack|package|Pick|pipe|pop|pos|print|printf|push|pwd|Quit|quotemeta|rand|read|readdir|readlink|recv|redo|ref|rename|Reply|require|reset|return|reverse|rewinddir|rindex|rmdir)\\b", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(scalar|seek|seekdir|select|semctl|semget|semop|send|SetFileInfo|setgrent|sethostent|setnetent|setpgrp|setpriority|setprotoent|setpwent|setservent|setsockopt|shift|shmctl|shmget|shmread|shmwrite|shutdown|sin|sleep|socket|socketpair|sort|splice|split|sprintf|sqrt|srand|stat|stty|study|sub|substr|symlink|syscall|sysopen|sysread|system|syswrite)\\b", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(tell|telldir|tie|tied|time|times|truncate|uc|ucfirst|umask|undef|unless|unlink|until|unpack|unshift|untie|use|utime|values|vec|Volumes|wait|waitpid|wantarray|warn|while|write)\\b", "")), CodeHighlighter::$common->functionName, _CodeHighlighter_Rule::Flat("variable", new EReg("^(\\@|\\\$|)[a-zA-Z_][a-zA-Z0-9_]*", "")), CodeHighlighter::$common->hashComment, CodeHighlighter::$common->number, CodeHighlighter::$common->doubleString, CodeHighlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("ruby"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("", new EReg("^::", "")), _CodeHighlighter_Rule::Flat("string", new EReg("^/(([^\\s/\\\\]|\\\\.)([^\\\\/]|\\\\.)*)?/[a-zA-Z]*", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(alias|and|BEGIN|begin|break|case|class|def|defined|do|else|elsif|END|end|ensure|false|for|if|in|module|next|nil|not|or|redo|rescue|retry|return|self|super|then|true|undef|unless|until|when|while|yield)\\b", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(require|include|raise|public|protected|private|)\\b", "")), _CodeHighlighter_Rule::Flat("string", new EReg("^:[a-zA-Z_][a-zA-Z0-9_]*", "")), _CodeHighlighter_Rule::Flat("type", CodeHighlighter::$patterns->upperIdentifier), CodeHighlighter::$common->functionName, _CodeHighlighter_Rule::Flat("variable", new EReg("^(\\@|\\\$|)[a-zA-Z_][a-zA-Z0-9_]*", "")), CodeHighlighter::$common->hashComment, CodeHighlighter::$common->number, CodeHighlighter::$common->doubleString, CodeHighlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("c++", "cpp", "c"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("keyword", new EReg("^(asm|auto|bool|break|case|catch|class|const|const_cast|continue|default|delete|do|double|dynamic_cast|else|enum|explicit|export|extern|false|float|for|friend|goto|if|inline|int|long|mutable|namespace|new|operator|private|protected|public|register|reinterpret_cast|return|short|signed|sizeof|static|static_cast|struct|switch|template|this|throw|true|try|typedef|typeid|typename|union|unsigned|using|virtual|void|volatile|wchar_t|while)\\b", "")), CodeHighlighter::$common->functionName, _CodeHighlighter_Rule::Flat("variable", CodeHighlighter::$patterns->identifier), _CodeHighlighter_Rule::Flat("type", new EReg("^#[a-zA-Z0-9_]+([^\\r\\n\\\\]|\\\\(\\r\\n|\\r|\\n|.))*", "")), CodeHighlighter::$common->docComment, CodeHighlighter::$common->blockComment, CodeHighlighter::$common->lineComment, CodeHighlighter::$common->number, CodeHighlighter::$common->doubleString, CodeHighlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("c#", "csharp", "c-sharp", "cs"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("keyword", new EReg("^(abstract|event|new|struct|as|explicit|null|switch|base|extern|object|this|bool|false|operator|throw|break|finally|out|true|byte|fixed|override|try|case|float|params|typeof|catch|for|private|uint|char|foreach|protected|ulong|checked|goto|public|unchecked|class|if|readonly|unsafe|const|implicit|ref|ushort|continue|in|return|using|decimal|int|sbyte|virtual|default|interface|sealed|volatile|delegate|internal|short|void|do|is|sizeof|while|double|lock|stackalloc|else|long|static|enum|namespace|string)\\b", "")), CodeHighlighter::$common->functionName, _CodeHighlighter_Rule::Flat("variable", CodeHighlighter::$patterns->identifier), CodeHighlighter::$common->docComment, CodeHighlighter::$common->blockComment, CodeHighlighter::$common->lineComment, CodeHighlighter::$common->number, CodeHighlighter::$common->doubleString, CodeHighlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("java"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("keyword", new EReg("^(abstract|assert|break|case|catch|class|continue|default|do|else|enum|extends|final|finally|for|if|implements|import|instanceof|interface|native|new|package|private|protected|public|return|static|strictfp|super|switch|synchronized|this|throw|throws|transient|try|volatile|while|true|false|null)\\b", "")), _CodeHighlighter_Rule::Flat("type", new EReg("^(boolean|byte|char|double|float|int|long|short|void)", "")), _CodeHighlighter_Rule::Flat("type", CodeHighlighter::$patterns->upperIdentifier), CodeHighlighter::$common->functionName, _CodeHighlighter_Rule::Flat("variable", CodeHighlighter::$patterns->lowerIdentifier), CodeHighlighter::$common->docComment, CodeHighlighter::$common->blockComment, CodeHighlighter::$common->lineComment, CodeHighlighter::$common->number, CodeHighlighter::$common->doubleString, CodeHighlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("haxe"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("keyword", new EReg("^(public|private|package|import|enum|class|interface|typedef|implements|extends|if|else|switch|case|default|for|in|do|while|continue|break|dynamic|untyped|cast|static|inline|extern|override|var|function|new|return|trace|try|catch|throw|this|null|true|false|super|typeof|undefined)\\b", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(\\#((if|elseif)(\\s+[a-zA-Z_]+)?|(else|end)))\\b", "")), _CodeHighlighter_Rule::Flat("type", CodeHighlighter::$patterns->upperIdentifier), CodeHighlighter::$common->functionName, _CodeHighlighter_Rule::Flat("variable", CodeHighlighter::$patterns->lowerIdentifier), CodeHighlighter::$common->docComment, CodeHighlighter::$common->blockComment, CodeHighlighter::$common->lineComment, CodeHighlighter::$common->number, CodeHighlighter::$common->doubleString, CodeHighlighter::$common->singleString, CodeHighlighter::$common->regex))), php_Boot::__anonymous(array("names" => php_Boot::__array("droid"), "rules" => php_Boot::__array(CodeHighlighter::$common->ignorable, _CodeHighlighter_Rule::Flat("keyword", new EReg("^(package|using|where|class|object|interface|enum|methods|pure|do|end)\\b", "")), _CodeHighlighter_Rule::Flat("keyword", new EReg("^(droid|scope|if|else|elseif|while|for|in|throw|catch|var|val|fun|switch|and|or|not|true|false|none|this)\\b", "")), CodeHighlighter::$common->number, CodeHighlighter::$common->doubleString, CodeHighlighter::$common->singleString, _CodeHighlighter_Rule::Flat("type", CodeHighlighter::$patterns->upperIdentifier), CodeHighlighter::$common->functionName, _CodeHighlighter_Rule::Flat("variable", new EReg("^([a-z][a-zA-Z0-9]*)", "")), _CodeHighlighter_Rule::Nested("doc-comment", _CodeHighlighter_Rule::Flat("comment", new EReg("^##", "")), _CodeHighlighter_Rule::Flat("comment", new EReg("^(\\r|\\n|\\r\\n)", ""))), CodeHighlighter::$common->regex, CodeHighlighter::$common->hashComment))));


class EReg {
	public function __construct($r, $opt) { if( !php_Boot::$skip_constructor ) {
		$this->pattern = $r;
		$this->options = $opt;
		$this->re = "/" . str_replace("/", "\\/", $r) . "/" . $opt;
	}}
	public $r;
	public $pattern;
	public $options;
	public $re;
	public $last;
	public $matches;
	public function match($s) {
		$p = preg_match($this->re, $s, $this->matches, PREG_OFFSET_CAPTURE);
		if($p > 0) $this->last = $s;
		else $this->last = null;
		return $p > 0;
	}
	public function matched($n) {
		if($n >= 0 && $n < count($this->matches)) {
			if($this->matches[$n][1] < 0) return null;
			return $this->matches[$n][0];
		}
		else throw new HException("EReg::matched");
	}
	public function matchedLeft() {
		if(count($this->matches) === 0) throw new HException("No string matched");
		return php_Boot::__substr($this->last, 0, $this->matches[0][1]);
	}
	public function matchedRight() {
		if(count($this->matches) === 0) throw new HException("No string matched");
		return php_Boot::__substr($this->last, $this->matches[0][1] + strlen($this->matches[0][0]), null);
	}
	public function matchedPos() {
		return php_Boot::__anonymous(array("pos" => $this->matches[0][1], "len" => strlen($this->matches[0][0])));
	}
	public function &split($s) {
		{
		$__r__ =& preg_split($this->re, $s);
		return $__r__;
		}
	}
	public function replace($s, $by) {
		$by = str_replace("\$\$", "\\\$", $by);
		if(!preg_match('/\\([^?].+?\\)/', $this->re)) $by = preg_replace('/\$(\d+)/', '\\\$\1', $by);
		return preg_replace($this->re, $by, $s);
	}
	public function customReplace($s, $f) {
		$buf = new StringBuf();
		while(true) {
			if(!$this->match($s)) break;
			$buf->b .= $this->matchedLeft();
			$buf->b .= call_user_func_array($f, array($this));
			$s = $this->matchedRight();
			;
		}
		$buf->b .= $s;
		return $buf->b;
	}
}


class Highlighter {
	public function __construct(){}
	static function main() {
		;
	}
	static function highlight($code, $languageName, $addLineNumbers) {
		return (($addLineNumbers ? Highlighter::lineNumbers($code) : "")) . "<div class=\"code-code\">" . Highlighter::highlightUntil(_Highlighter_Rule::Flat("", new EReg("^\$", "")), $code, $languageName)->html . "</div>";
	}
	static function highlightUntil($stopRule, $code, $languageName) {
		$language = null;
		{
			$_g = 0; $_g1 =& Highlighter::$languages;
			while($_g < count($_g1)) {
				$l = $_g1[$_g];
				++$_g;
				{
					$_g2 = 0; $_g3 =& $l->names;
					while($_g2 < count($_g3)) {
						$n = $_g3[$_g2];
						++$_g2;
						if(strtolower($n) == strtolower($languageName)) $language = $l;
						unset($n);
					}
				}
				unset($_g2); unset($_g3); unset($l); unset($n);
			}
		}
		if($language === null) return php_Boot::__anonymous(array("html" => $code, "rest" => ""));
		$rules =& array_merge(php_Boot::__array($stopRule), $language->rules);
		$html = new StringBuf();
		$tryRule = null;
		$tryRule = php_Boot::__closure(array("_g" => &$_g, "_g1" => &$_g1, "_g2" => &$_g2, "_g3" => &$_g3, "code" => &$code, "html" => &$html, "l" => &$l, "language" => &$language, "languageName" => &$languageName, "n" => &$n, "rules" => &$rules, "stopRule" => &$stopRule, "tryRule" => &$tryRule), "\$rule", "{
			\$__t__ = (\$rule);
			switch(\$__t__->index) {
			case 0:
			\$pattern = \$__t__->params[1]; \$type = \$__t__->params[0];
			{
				if(!\$pattern->match(\$code)) return _Highlighter_Match::\$NotMatched;
				\$s = \$pattern->matched(0);
				if(strlen(\$s) === 0 && \$rule !== \$stopRule) return _Highlighter_Match::\$NotMatched;
				\$html->b .= Highlighter::markup(\$s, \$type);
				\$code = php_Boot::__substr(\$code, strlen(\$s), null);
			}break;
			case 1:
			\$stop = \$__t__->params[2]; \$start = \$__t__->params[1]; \$language1 = \$__t__->params[0];
			{
				\$match = call_user_func_array(\$tryRule, array(\$start));
				\$__t__2 = (\$match);
				switch(\$__t__2->index) {
				case 1:
				{
					\$h = Highlighter::highlightUntil(\$stop, \$code, \$language1);
					\$html->b .= \$h->html;
					\$code = \$h->rest;
				}break;
				default:{
					return \$match;
				}break;
				}
			}break;
			}
			if(\$rule === \$stopRule) return _Highlighter_Match::\$Done;
			return _Highlighter_Match::\$Matched;
		}");
		while(true) {
			$next = false;
			{
				$_g4 = 0;
				while($_g4 < count($rules)) {
					$rule = $rules[$_g4];
					++$_g4;
					$__t__ = (call_user_func_array($tryRule, array($rule)));
					switch($__t__->index) {
					case 0:
					{
						return php_Boot::__anonymous(array("html" => $html->b, "rest" => $code));
					}break;
					case 1:
					{
						$next = true;
					}break;
					case 2:
					{
						;
					}break;
					}
					if($next) break;
					unset($__t__); unset($rule);
				}
			}
			if(!$next) {
				$html->b .= StringTools::htmlEscape(php_Boot::__substr($code, 0, 1));
				$code = php_Boot::__substr($code, 1, null);
			}
			unset($__t__); unset($_g4); unset($next); unset($rule);
		}
		return null;
	}
	static function markup($code, $type) {
		if(strlen($type) === 0) return StringTools::htmlEscape($code);
		return "<span class=\"code-" . $type . "\">" . StringTools::htmlEscape($code) . "</span>";
	}
	static function lineNumbers($code) {
		$ns =& explode("\n", $code);
		$rs =& explode("\r", $code);
		$lines = (count($ns) > count($rs) ? $ns : $rs);
		$count = count($lines);
		$last = array_pop($lines);
		if($last !== null && (strlen($last) === 0 || $last == "\n" || $last == "\r")) {
			$count -= 1;
		}
		$html = new StringBuf();
		$html->b .= "<div class=\"code-line-numbers\" name=\"code-line-numbers\">";
		{
			$_g = 0;
			while($_g < $count) {
				$i = $_g++;
				if($i !== 0) $html->b .= "\n";
				$html->b .= $i + 1;
				unset($i);
			}
		}
		$html->b .= "</div>";
		return $html->b;
	}
	static $patterns;
	static $common;
	static $languages;
}
Highlighter::$patterns = php_Boot::__anonymous(array("ignorable" => new EReg("^[ \\t\\r\\n]+", ""), "doubleString" => new EReg("^([\"]([^\\\\\"]|\\\\.)*[\"])", ""), "singleString" => new EReg("^([']([^'\\\\]|['][']|\\\\.)*['])", ""), "number" => new EReg("^([0-9]+([.][0-9]+)?([eE][+-]?[0-9]+)?)[a-zA-Z]?", ""), "dollarIdentifier" => new EReg("^([\$][a-zA-Z0-9_]*)", ""), "identifier" => new EReg("^([a-zA-Z_][a-zA-Z0-9_]*)", ""), "upperIdentifier" => new EReg("^([A-Z][a-zA-Z0-9_]*)", ""), "lowerIdentifier" => new EReg("^([a-z_][a-zA-Z0-9_]*)", ""), "docCommentBegin" => new EReg("^/\\*\\*", ""), "docCommentEnd" => new EReg("^\\*/", ""), "blockComment" => new EReg("^([/][*]([^*]|[*][^/])*[*][/])", ""), "lineComment" => new EReg("^([/][/][^\\n]*)", ""), "entity" => new EReg("^([&][^;]+[;])", "")));
Highlighter::$common = php_Boot::__anonymous(array("ignorable" => _Highlighter_Rule::Flat("", Highlighter::$patterns->ignorable), "docComment" => _Highlighter_Rule::Nested("doc-comment", _Highlighter_Rule::Flat("comment", Highlighter::$patterns->docCommentBegin), _Highlighter_Rule::Flat("comment", Highlighter::$patterns->docCommentEnd)), "blockComment" => _Highlighter_Rule::Flat("comment", Highlighter::$patterns->blockComment), "lineComment" => _Highlighter_Rule::Flat("comment", Highlighter::$patterns->lineComment), "hashComment" => _Highlighter_Rule::Flat("comment", new EReg("^([#][^\\n\\r]*)", "")), "number" => _Highlighter_Rule::Flat("number", Highlighter::$patterns->number), "doubleString" => _Highlighter_Rule::Flat("string", Highlighter::$patterns->doubleString), "singleString" => _Highlighter_Rule::Flat("string", Highlighter::$patterns->singleString), "functionName" => _Highlighter_Rule::Flat("", new EReg("^([a-zA-Z_][a-zA-Z0-9_]*\\s*[(])", "")), "regex" => _Highlighter_Rule::Flat("string", new EReg("^\\~/([^\\\\/]|\\\\.)*/[a-zA-Z]*", ""))));
Highlighter::$languages = php_Boot::__array(php_Boot::__anonymous(array("names" => php_Boot::__array("xml-attributes"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("type", new EReg("^[a-zA-Z0-9_.-]+", "")), Highlighter::$common->doubleString, Highlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("html", "xhtml", "xml"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("comment", new EReg("^(<[!]--([^-]|[-][^-]|[-][-][^>])*-->)", "")), _Highlighter_Rule::Flat("variable", new EReg("^(<[!]\\[CDATA\\[([^\\]]|\\][^\\]]|\\]\\][^>])*\\]\\]>)", "i")), _Highlighter_Rule::Flat("keyword", new EReg("^(<[%]([^%]|[%][^>])*[%]>)", "")), _Highlighter_Rule::Nested("css", _Highlighter_Rule::Nested("xml-attributes", _Highlighter_Rule::Flat("keyword", new EReg("^<\\s*style\\b", "i")), _Highlighter_Rule::Flat("keyword", new EReg("^>", ""))), _Highlighter_Rule::Flat("keyword", new EReg("^<\\s*/\\s*style\\s*>", "i"))), _Highlighter_Rule::Nested("javascript", _Highlighter_Rule::Nested("xml-attributes", _Highlighter_Rule::Flat("keyword", new EReg("^<\\s*script\\b", "i")), _Highlighter_Rule::Flat("keyword", new EReg("^>", ""))), _Highlighter_Rule::Flat("keyword", new EReg("^<\\s*/\\s*script\\s*>", "i"))), _Highlighter_Rule::Nested("php", _Highlighter_Rule::Flat("keyword", new EReg("^<[?](php[0-9]*)?", "i")), _Highlighter_Rule::Flat("keyword", new EReg("^[?]>", ""))), _Highlighter_Rule::Nested("xml-attributes", _Highlighter_Rule::Flat("keyword", new EReg("^<\\s*[a-zA-Z0-9_.-]+", "")), _Highlighter_Rule::Flat("keyword", new EReg("^>", ""))), _Highlighter_Rule::Flat("keyword", new EReg("^(<\\s*/\\s*[a-zA-Z0-9_.-]+)\\s*(>)", "")), _Highlighter_Rule::Flat("variable", Highlighter::$patterns->entity), _Highlighter_Rule::Flat("", new EReg("^[^<&]+", ""))))), php_Boot::__anonymous(array("names" => php_Boot::__array("css"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("variable", new EReg("^([a-zA-Z-]+[:])", "")), _Highlighter_Rule::Flat("number", new EReg("^([#][0-9a-fA-F]{6}|[0-9]+[a-zA-Z%]*)", "")), _Highlighter_Rule::Flat("type", new EReg("^([#.:]?[a-zA-Z>-][a-zA-Z0-9>-]*)", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(url|rgb|rect|inherit)\\b", "")), _Highlighter_Rule::Flat("comment", new EReg("^(<!--|-->)", "")), Highlighter::$common->blockComment))), php_Boot::__anonymous(array("names" => php_Boot::__array("wikitalis", "wiki"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("keyword", new EReg("^(\\\\[a-zA-Z]+)", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(\\{|\\})", "")), _Highlighter_Rule::Flat("", new EReg("^[^\\\\{}]+", ""))))), php_Boot::__anonymous(array("names" => php_Boot::__array("ebnf", "bnf"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("keyword", new EReg("^(\\:\\:\\=|\\[|\\]|\\{|\\})", "")), _Highlighter_Rule::Flat("type", new EReg("^(<[a-zA-Z0-9 _-]+>)", "")), _Highlighter_Rule::Flat("comment", new EReg("^([?][^?]*[?])", "")), Highlighter::$common->doubleString, _Highlighter_Rule::Flat("string", Highlighter::$patterns->identifier)))), php_Boot::__anonymous(array("names" => php_Boot::__array("doc-comment"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("type", new EReg("^[@][a-zA-Z0-9_-]+", "")), _Highlighter_Rule::Flat("variable", new EReg("^[<]/?[a-zA-Z0-9_.-]+[^>]*[>]", "")), _Highlighter_Rule::Flat("comment", new EReg("^([^@<*\\r\\n]+|.)", ""))))), php_Boot::__anonymous(array("names" => php_Boot::__array("php"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("keyword", new EReg("^(and|or|xor|__FILE__|exception|__LINE__|array|as|break|case|class|const|continue|declare|default|die|do|echo|else|elseif|empty|enddeclare|endfor|endforeach|endif|endswitch|endwhile|eval|exit|extends|for|foreach|function|global|if|include|include_once|isset|list|new|print|require|require_once|return|static|switch|unset|use|var|while|__FUNCTION__|__CLASS__|__METHOD__|final|php_user_filter|interface|implements|instanceof|public|private|protected|abstract|clone|try|catch|throw|cfunction|old_function|this|final|__NAMESPACE__|namespace|goto|__DIR__)\\b", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(<\\?(php[0-9]*)?\\b|\\?>)", "")), Highlighter::$common->functionName, _Highlighter_Rule::Flat("variable", Highlighter::$patterns->dollarIdentifier), Highlighter::$common->docComment, Highlighter::$common->blockComment, Highlighter::$common->lineComment, Highlighter::$common->number, Highlighter::$common->doubleString, Highlighter::$common->singleString, _Highlighter_Rule::Flat("", new EReg("^[a-zA-Z0-9]+", ""))))), php_Boot::__anonymous(array("names" => php_Boot::__array("javascript", "jscript", "js"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("keyword", new EReg("^(abstract|boolean|break|byte|case|catch|char|class|const|continue|debugger|default|delete|do|double)\\b", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(else|enum|export|extends|false|final|finally|float|for|function|goto|if|implements|import|in)\\b", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(instanceof|int|interface|long|native|new|null|package|private|protected|public|return|short|static|super)\\b", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(switch|synchronized|this|throw|throws|transient|true|try|typeof|var|void|volatile|while|with)\\b", "")), _Highlighter_Rule::Flat("type", Highlighter::$patterns->entity), Highlighter::$common->functionName, _Highlighter_Rule::Flat("variable", new EReg("^[a-zA-Z_\$][a-zA-Z0-9_]*", "")), _Highlighter_Rule::Flat("comment", new EReg("^(<!--|-->)", "")), Highlighter::$common->docComment, Highlighter::$common->blockComment, Highlighter::$common->lineComment, Highlighter::$common->number, Highlighter::$common->doubleString, Highlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("perl"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("string", new EReg("^(m|q|qq|qw|qx)/([^\\\\/]|\\\\.)*/[a-zA-Z]*", "")), _Highlighter_Rule::Flat("string", new EReg("^(y|tr|s)/([^\\\\/]|\\\\.)*/([^\\\\/]|\\\\.)*/[a-zA-Z]*", "")), _Highlighter_Rule::Flat("string", new EReg("^/(([^\\s/\\\\]|\\\\.)([^\\\\/]|\\\\.)*)?/[a-zA-Z]*", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(abs|accept|alarm|Answer|Ask|atan2|bind|binmode|bless|caller|chdir|chmod|chomp|Choose|chop|chown|chr|chroot|close|closedir|connect|continue|cos|crypt|dbmclose|dbmopen|defined|delete|die|Directory|do|DoAppleScript|dump)\\b", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(each|else|elsif|endgrent|endhostent|endnetent|endprotoent|endpwent|eof|eval|exec|exists|exit|exp|FAccess|fcntl|fileno|find|flock|for|foreach|fork|format|formline)\\b", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(getc|GetFileInfo|getgrent|getgrgid|getgrnam|gethostbyaddr|gethostbyname|gethostent|getlogin|getnetbyaddr|getnetbyname|getnetent|getpeername|getpgrp|getppid|getpriority|getprotobyname|getprotobynumber|getprotoent|getpwent|getpwnam|getpwuid|getservbyaddr|getservbyname|getservbyport|getservent|getsockname|getsockopt|glob|gmtime|goto|grep)\\b", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(hex|hostname|if|import|index|int|ioctl|join|keys|kill|last|lc|lcfirst|length|link|listen|LoadExternals|local|localtime|log|lstat|MakeFSSpec|MakePath|map|mkdir|msgctl|msgget|msgrcv|msgsnd|my|next|no|oct|open|opendir|ord)\\b", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(pack|package|Pick|pipe|pop|pos|print|printf|push|pwd|Quit|quotemeta|rand|read|readdir|readlink|recv|redo|ref|rename|Reply|require|reset|return|reverse|rewinddir|rindex|rmdir)\\b", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(scalar|seek|seekdir|select|semctl|semget|semop|send|SetFileInfo|setgrent|sethostent|setnetent|setpgrp|setpriority|setprotoent|setpwent|setservent|setsockopt|shift|shmctl|shmget|shmread|shmwrite|shutdown|sin|sleep|socket|socketpair|sort|splice|split|sprintf|sqrt|srand|stat|stty|study|sub|substr|symlink|syscall|sysopen|sysread|system|syswrite)\\b", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(tell|telldir|tie|tied|time|times|truncate|uc|ucfirst|umask|undef|unless|unlink|until|unpack|unshift|untie|use|utime|values|vec|Volumes|wait|waitpid|wantarray|warn|while|write)\\b", "")), Highlighter::$common->functionName, _Highlighter_Rule::Flat("variable", new EReg("^(\\@|\\\$|)[a-zA-Z_][a-zA-Z0-9_]*", "")), Highlighter::$common->hashComment, Highlighter::$common->number, Highlighter::$common->doubleString, Highlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("ruby"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("", new EReg("^::", "")), _Highlighter_Rule::Flat("string", new EReg("^/(([^\\s/\\\\]|\\\\.)([^\\\\/]|\\\\.)*)?/[a-zA-Z]*", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(alias|and|BEGIN|begin|break|case|class|def|defined|do|else|elsif|END|end|ensure|false|for|if|in|module|next|nil|not|or|redo|rescue|retry|return|self|super|then|true|undef|unless|until|when|while|yield)\\b", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(require|include|raise|public|protected|private|)\\b", "")), _Highlighter_Rule::Flat("string", new EReg("^:[a-zA-Z_][a-zA-Z0-9_]*", "")), _Highlighter_Rule::Flat("type", Highlighter::$patterns->upperIdentifier), Highlighter::$common->functionName, _Highlighter_Rule::Flat("variable", new EReg("^(\\@|\\\$|)[a-zA-Z_][a-zA-Z0-9_]*", "")), Highlighter::$common->hashComment, Highlighter::$common->number, Highlighter::$common->doubleString, Highlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("c++", "cpp", "c"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("keyword", new EReg("^(asm|auto|bool|break|case|catch|class|const|const_cast|continue|default|delete|do|double|dynamic_cast|else|enum|explicit|export|extern|false|float|for|friend|goto|if|inline|int|long|mutable|namespace|new|operator|private|protected|public|register|reinterpret_cast|return|short|signed|sizeof|static|static_cast|struct|switch|template|this|throw|true|try|typedef|typeid|typename|union|unsigned|using|virtual|void|volatile|wchar_t|while)\\b", "")), Highlighter::$common->functionName, _Highlighter_Rule::Flat("variable", Highlighter::$patterns->identifier), _Highlighter_Rule::Flat("type", new EReg("^#[a-zA-Z0-9_]+([^\\r\\n\\\\]|\\\\(\\r\\n|\\r|\\n|.))*", "")), Highlighter::$common->docComment, Highlighter::$common->blockComment, Highlighter::$common->lineComment, Highlighter::$common->number, Highlighter::$common->doubleString, Highlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("c#", "csharp", "c-sharp", "cs"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("keyword", new EReg("^(abstract|event|new|struct|as|explicit|null|switch|base|extern|object|this|bool|false|operator|throw|break|finally|out|true|byte|fixed|override|try|case|float|params|typeof|catch|for|private|uint|char|foreach|protected|ulong|checked|goto|public|unchecked|class|if|readonly|unsafe|const|implicit|ref|ushort|continue|in|return|using|decimal|int|sbyte|virtual|default|interface|sealed|volatile|delegate|internal|short|void|do|is|sizeof|while|double|lock|stackalloc|else|long|static|enum|namespace|string)\\b", "")), Highlighter::$common->functionName, _Highlighter_Rule::Flat("variable", Highlighter::$patterns->identifier), Highlighter::$common->docComment, Highlighter::$common->blockComment, Highlighter::$common->lineComment, Highlighter::$common->number, Highlighter::$common->doubleString, Highlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("java"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("keyword", new EReg("^(abstract|assert|break|case|catch|class|continue|default|do|else|enum|extends|final|finally|for|if|implements|import|instanceof|interface|native|new|package|private|protected|public|return|static|strictfp|super|switch|synchronized|this|throw|throws|transient|try|volatile|while|true|false|null)\\b", "")), _Highlighter_Rule::Flat("type", new EReg("^(boolean|byte|char|double|float|int|long|short|void)", "")), _Highlighter_Rule::Flat("type", Highlighter::$patterns->upperIdentifier), Highlighter::$common->functionName, _Highlighter_Rule::Flat("variable", Highlighter::$patterns->lowerIdentifier), Highlighter::$common->docComment, Highlighter::$common->blockComment, Highlighter::$common->lineComment, Highlighter::$common->number, Highlighter::$common->doubleString, Highlighter::$common->singleString))), php_Boot::__anonymous(array("names" => php_Boot::__array("haxe"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("keyword", new EReg("^(public|private|package|import|enum|class|interface|typedef|implements|extends|if|else|switch|case|default|for|in|do|while|continue|break|dynamic|untyped|cast|static|inline|extern|override|var|function|new|return|trace|try|catch|throw|this|null|true|false|super|typeof|undefined)\\b", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(\\#((if|elseif)(\\s+[a-zA-Z_]+)?|(else|end)))\\b", "")), _Highlighter_Rule::Flat("type", Highlighter::$patterns->upperIdentifier), Highlighter::$common->functionName, _Highlighter_Rule::Flat("variable", Highlighter::$patterns->lowerIdentifier), Highlighter::$common->docComment, Highlighter::$common->blockComment, Highlighter::$common->lineComment, Highlighter::$common->number, Highlighter::$common->doubleString, Highlighter::$common->singleString, Highlighter::$common->regex))), php_Boot::__anonymous(array("names" => php_Boot::__array("droid"), "rules" => php_Boot::__array(Highlighter::$common->ignorable, _Highlighter_Rule::Flat("keyword", new EReg("^(package|using|where|class|object|interface|enum|methods|do|end)\\b", "")), _Highlighter_Rule::Flat("keyword", new EReg("^(scope|if|else|elseif|while|for|in|throw|catch|var|val|fun|switch|and|or|not|true|false|none|this)\\b", "")), Highlighter::$common->number, Highlighter::$common->doubleString, Highlighter::$common->singleString, _Highlighter_Rule::Flat("type", Highlighter::$patterns->upperIdentifier), Highlighter::$common->functionName, _Highlighter_Rule::Flat("variable", new EReg("^([a-z][a-zA-Z0-9]*)", "")), _Highlighter_Rule::Nested("doc-comment", _Highlighter_Rule::Flat("comment", new EReg("^##", "")), _Highlighter_Rule::Flat("comment", new EReg("^(\\r|\\n|\\r\\n)", ""))), Highlighter::$common->regex, Highlighter::$common->hashComment))));


class IntIter {
	public function __construct($min, $max) { if( !php_Boot::$skip_constructor ) {
		$this->min = $min;
		$this->max = $max;
	}}
	public $min;
	public $max;
	public function hasNext() {
		return $this->min < $this->max;
	}
	public function next() {
		return $this->min++;
	}
}


class Rule extends enum {
		public static function Flat($type, $pattern) { return new Rule("Flat", 0, array($type, $pattern)); }
		public static function Nested($type, $language, $background, $start, $end) { return new Rule("Nested", 1, array($type, $language, $background, $start, $end)); }
	}


class Std {
	public function __construct(){}
	static function is($v, $t) {
		return php_Boot::__instanceof($v, $t);
	}
	static function string($s) {
		return php_Boot::__string_rec($s, php_Boot::__array_null());
	}
	static function int($x) {
		return intval($x);
	}
	static function parseInt($x) {
		if(!is_numeric($x)) return null;
		return (strtolower(php_Boot::__substr($x, 0, 2)) == "0x" ? intval(substr($x, 2), 16) : intval($x));
	}
	static function parseFloat($x) {
		return is_numeric($x) ? floatval($x) : acos(1.01);
	}
	static function random($x) {
		return rand(0, $x - 1);
	}
}
php_Boot::__anonymous(array());


class StringBuf {
	public function __construct() { if( !php_Boot::$skip_constructor ) {
		$this->b = "";
	}}
	public function add($x) {
		$this->b .= php_Boot::__string($x);
	}
	public function addSub($s, $pos, $len) {
		$this->b .= php_Boot::__substr($s, $pos, $len);
	}
	public function addChar($c) {
		$this->b .= chr($c);
	}
	public function toString() {
		return $this->b;
	}
	public $b;
}


class StringTools {
	public function __construct(){}
	static function urlEncode($s) {
		return rawurlencode($s);
	}
	static function urlDecode($s) {
		return urldecode($s);
	}
	static function htmlEscape($s) {
		return join("&gt;", explode(">", join("&lt;", explode("<", join("&amp;", explode("&", $s))))));
	}
	static function htmlUnescape($s) {
		return htmlspecialchars_decode($s);
	}
	static function startsWith($s, $start) {
		return (strlen($s) >= strlen($start) && php_Boot::__substr($s, 0, strlen($start)) == $start);
	}
	static function endsWith($s, $end) {
		$elen = strlen($end);
		$slen = strlen($s);
		return ($slen >= $elen && php_Boot::__substr($s, $slen - $elen, $elen) == $end);
	}
	static function isSpace($s, $pos) {
		$c = php_Boot::__char_code_at($s, $pos);
		return ($c >= 9 && $c <= 13) || $c === 32;
	}
	static function ltrim($s) {
		return ltrim($s);
	}
	static function rtrim($s) {
		return rtrim($s);
	}
	static function trim($s) {
		return trim($s);
	}
	static function rpad($s, $c, $l) {
		return str_pad($s, $l, $c, STR_PAD_RIGHT);
	}
	static function lpad($s, $c, $l) {
		return str_pad($s, $l, $c, STR_PAD_LEFT);
	}
	static function replace($s, $sub, $by) {
		return str_replace($sub, $by, $s);
	}
	static function baseEncode($s, $base) {
		$len = strlen($base);
		$nbits = 1;
		while($len > 1 << $nbits) $nbits++;
		if($nbits > 8 || $len !== 1 << $nbits) throw new HException("baseEncode: base must be a power of two.");
		$size = intval((strlen($s) * 8 + $nbits - 1) / $nbits);
		$out = new StringBuf();
		$buf = 0;
		$curbits = 0;
		$mask = ((1 << $nbits) - 1);
		$pin = 0;
		while($size-- > 0) {
			while($curbits < $nbits) {
				$curbits += 8;
				$buf <<= 8;
				$t = php_Boot::__char_code_at($s, $pin++);
				if($t > 255) throw new HException("baseEncode: bad chars");
				$buf |= $t;
				unset($t);
			}
			$curbits -= $nbits;
			$out->b .= chr(php_Boot::__char_code_at($base, ($buf >> $curbits) & $mask));
			unset($t);
		}
		return $out->b;
	}
	static function baseDecode($s, $base) {
		$len = strlen($base);
		$nbits = 1;
		while($len > 1 << $nbits) $nbits++;
		if($nbits > 8 || $len !== 1 << $nbits) throw new HException("baseDecode: base must be a power of two.");
		$size = (strlen($s) * 8 + $nbits - 1) / $nbits;
		$tbl = php_Boot::__array_empty();
		{
			$_g = 0;
			while($_g < 256) {
				$i = $_g++;
				php_Boot::__array_set($tbl, $i, -1);
				unset($i);
			}
		}
		{
			$_g2 = 0;
			while($_g2 < $len) {
				$i2 = $_g2++;
				php_Boot::__array_set($tbl, php_Boot::__char_code_at($base, $i2), $i2);
				unset($i2);
			}
		}
		$size1 = (strlen($s) * $nbits) / 8;
		$out = new StringBuf();
		$buf = 0;
		$curbits = 0;
		$pin = 0;
		while($size1-- > 0) {
			while($curbits < 8) {
				$curbits += $nbits;
				$buf <<= $nbits;
				$i3 = $tbl[php_Boot::__char_code_at($s, $pin++)];
				if($i3 === -1) throw new HException("baseDecode: bad chars");
				$buf |= $i3;
				unset($i3);
			}
			$curbits -= 8;
			$out->b .= chr(($buf >> $curbits) & 255);
			unset($i3);
		}
		return $out->b;
	}
	static function hex($n, $digits) {
		$neg = false;
		if($n < 0) {
			$neg = true;
			$n = -$n;
		}
		$s = "";
		$hexChars = "0123456789ABCDEF";
		do {
			$s = substr($hexChars, $n % 16, 1) . $s;
			$n = intval($n / 16);
			;
		} while($n > 0);
		if($digits !== null) while(strlen($s) < $digits) $s = "0" . $s;
		if($neg) $s = "-" . $s;
		return $s;
	}
}
