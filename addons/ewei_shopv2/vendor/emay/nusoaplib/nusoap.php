<?php
class nusoap_base
{
	/**
	 * Identification for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $title = 'NuSOAP';
	/**
	 * Version for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $version = '0.9.5';
	/**
	 * CVS revision for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $revision = '$Revision: 1.123 $';
	/**
     * Current error string (manipulated by getError/setError)
	 *
	 * @var string
	 * @access private
	 */
	public $error_str = '';
	/**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
	 *
	 * @var string
	 * @access private
	 */
	public $debug_str = '';
	/**
	 * toggles automatic encoding of special characters as entities
	 * (should always be true, I think)
	 *
	 * @var boolean
	 * @access private
	 */
	public $charencoding = true;
	/**
	 * the debug level for this instance
	 *
	 * @var	integer
	 * @access private
	 */
	public $debugLevel;
	/**
	* set schema version
	*
	* @var      string
	* @access   public
	*/
	public $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';
	/**
	* charset encoding for outgoing messages
	*
	* @var      string
	* @access   public
	*/
	public $soap_defencoding = 'ISO-8859-1';
	/**
	* namespaces in an array of prefix => uri
	*
	* this is "seeded" by a set of constants, but it may be altered by code
	*
	* @var      array
	* @access   public
	*/
	public $namespaces = array('SOAP-ENV' => 'http://schemas.xmlsoap.org/soap/envelope/', 'xsd' => 'http://www.w3.org/2001/XMLSchema', 'xsi' => 'http://www.w3.org/2001/XMLSchema-instance', 'SOAP-ENC' => 'http://schemas.xmlsoap.org/soap/encoding/');
	/**
	* namespaces used in the current context, e.g. during serialization
	*
	* @var      array
	* @access   private
	*/
	public $usedNamespaces = array();
	/**
	* XML Schema types in an array of uri => (array of xml type => php type)
	* is this legacy yet?
	* no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
	* @var      array
	* @access   public
	*/
	public $typemap = array(
		'http://www.w3.org/2001/XMLSchema'          => array('string' => 'string', 'boolean' => 'boolean', 'float' => 'double', 'double' => 'double', 'decimal' => 'double', 'duration' => '', 'dateTime' => 'string', 'time' => 'string', 'date' => 'string', 'gYearMonth' => '', 'gYear' => '', 'gMonthDay' => '', 'gDay' => '', 'gMonth' => '', 'hexBinary' => 'string', 'base64Binary' => 'string', 'anyType' => 'string', 'anySimpleType' => 'string', 'normalizedString' => 'string', 'token' => 'string', 'language' => '', 'NMTOKEN' => '', 'NMTOKENS' => '', 'Name' => '', 'NCName' => '', 'ID' => '', 'IDREF' => '', 'IDREFS' => '', 'ENTITY' => '', 'ENTITIES' => '', 'integer' => 'integer', 'nonPositiveInteger' => 'integer', 'negativeInteger' => 'integer', 'long' => 'integer', 'int' => 'integer', 'short' => 'integer', 'byte' => 'integer', 'nonNegativeInteger' => 'integer', 'unsignedLong' => '', 'unsignedInt' => '', 'unsignedShort' => '', 'unsignedByte' => '', 'positiveInteger' => ''),
		'http://www.w3.org/2000/10/XMLSchema'       => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://www.w3.org/1999/XMLSchema'          => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://soapinterop.org/xsd'                => array('SOAPStruct' => 'struct'),
		'http://schemas.xmlsoap.org/soap/encoding/' => array('base64' => 'string', 'array' => 'array', 'Array' => 'array'),
		'http://xml.apache.org/xml-soap'            => array('Map')
		);
	/**
	* XML entities to convert
	*
	* @var      array
	* @access   public
	* @deprecated
	* @see	expandEntities
	*/
	public $xmlEntities = array('quot' => '"', 'amp' => '&', 'lt' => '<', 'gt' => '>', 'apos' => '\'');

	/**
	* constructor
	*
	* @access	public
	*/
	public function nusoap_base()
	{
		$this->debugLevel = $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* gets the global debug level, which applies to future instances
	*
	* @return	integer	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getGlobalDebugLevel()
	{
		return $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* sets the global debug level, which applies to future instances
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setGlobalDebugLevel($level)
	{
		$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = $level;
	}

	/**
	* gets the debug level for this instance
	*
	* @return	int	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}

	/**
	* sets the debug level for this instance
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}

	/**
	* adds debug data to the instance debug string with formatting
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function debug($string)
	{
		if (0 < $this->debugLevel) {
			$this->appendDebug($this->getmicrotime() . ' ' . get_class($this) . (': ' . $string . "\n"));
		}
	}

	/**
	* adds debug data to the instance debug string without formatting
	*
	* @param    string $string debug data
	* @access   public
	*/
	public function appendDebug($string)
	{
		if (0 < $this->debugLevel) {
			$this->debug_str .= $string;
		}
	}

	/**
	* clears the current debug data for this instance
	*
	* @access   public
	*/
	public function clearDebug()
	{
		$this->debug_str = '';
	}

	/**
	* gets the current debug data for this instance
	*
	* @return   debug data
	* @access   public
	*/
	public function& getDebug()
	{
		return $this->debug_str;
	}

	/**
	* gets the current debug data for this instance as an XML comment
	* this may change the contents of the debug data
	*
	* @return   debug data as an XML comment
	* @access   public
	*/
	public function& getDebugAsXMLComment()
	{
		while (strpos($this->debug_str, '--')) {
			$this->debug_str = str_replace('--', '- -', $this->debug_str);
		}

		$ret = "<!--\n" . $this->debug_str . "\n-->";
		return $ret;
	}

	/**
	* expands entities, e.g. changes '<' to '&lt;'.
	*
	* @param	string	$val	The string in which to expand entities.
	* @access	private
	*/
	public function expandEntities($val)
	{
		if ($this->charencoding) {
			$val = str_replace('&', '&amp;', $val);
			$val = str_replace('\'', '&apos;', $val);
			$val = str_replace('"', '&quot;', $val);
			$val = str_replace('<', '&lt;', $val);
			$val = str_replace('>', '&gt;', $val);
		}

		return $val;
	}

	/**
	* returns error string if present
	*
	* @return   mixed error string or false
	* @access   public
	*/
	public function getError()
	{
		if ($this->error_str != '') {
			return $this->error_str;
		}

		return false;
	}

	/**
	* sets error string
	*
	* @return   boolean $string error string
	* @access   private
	*/
	public function setError($str)
	{
		$this->error_str = $str;
	}

	/**
	* detect if array is a simple array or a struct (associative array)
	*
	* @param	mixed	$val	The PHP array
	* @return	string	(arraySimple|arrayStruct)
	* @access	private
	*/
	public function isArraySimpleOrStruct($val)
	{
		$keyList = array_keys($val);

		foreach ($keyList as $keyListValue) {
			if (!is_int($keyListValue)) {
				return 'arrayStruct';
			}
		}

		return 'arraySimple';
	}

	/**
	* serializes PHP values in accordance w/ section 5. Type information is
	* not serialized if $use == 'literal'.
	*
	* @param	mixed	$val	The value to serialize
	* @param	string	$name	The name (local part) of the XML element
	* @param	string	$type	The XML schema type (local part) for the element
	* @param	string	$name_ns	The namespace for the name of the XML element
	* @param	string	$type_ns	The namespace for the type of the element
	* @param	array	$attributes	The attributes to serialize as name=>value pairs
	* @param	string	$use	The WSDL "use" (encoded|literal)
	* @param	boolean	$soapval	Whether this is called from soapval.
	* @return	string	The serialized element, possibly with child elements
    * @access	public
	*/
	public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = 'encoded', $soapval = false)
	{
		$this->debug('in serialize_val: name=' . $name . ', type=' . $type . ', name_ns=' . $name_ns . ', type_ns=' . $type_ns . ', use=' . $use . ', soapval=' . $soapval);
		$this->appendDebug('value=' . $this->varDump($val));
		$this->appendDebug('attributes=' . $this->varDump($attributes));
		if (is_object($val) && get_class($val) == 'soapval' && !$soapval) {
			$this->debug('serialize_val: serialize soapval');
			$xml = $val->serialize($use);
			$this->appendDebug($val->getDebug());
			$val->clearDebug();
			$this->debug('serialize_val of soapval returning ' . $xml);
			return $xml;
		}

		if (is_numeric($name)) {
			$name = '__numeric_' . $name;
		}
		else {
			if (!$name) {
				$name = 'noname';
			}
		}

		$xmlns = '';

		if ($name_ns) {
			$prefix = 'nu' . rand(1000, 9999);
			$name = $prefix . ':' . $name;
			$xmlns .= ' xmlns:' . $prefix . '="' . $name_ns . '"';
		}

		if ($type_ns != '' && $type_ns == $this->namespaces['xsd']) {
			$type_prefix = 'xsd';
		}
		else {
			if ($type_ns) {
				$type_prefix = 'ns' . rand(1000, 9999);
				$xmlns .= ' xmlns:' . $type_prefix . '="' . $type_ns . '"';
			}
		}

		$atts = '';

		if ($attributes) {
			foreach ($attributes as $k => $v) {
				$atts .= ' ' . $k . '="' . $this->expandEntities($v) . '"';
			}
		}

		if (is_null($val)) {
			$this->debug('serialize_val: serialize null');

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '/>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			$xml = '<' . $name . $xmlns . $type_str . $atts . ' xsi:nil="true"/>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		if ($type != '' && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
			$this->debug('serialize_val: serialize xsd built-in primitive type');

			if (is_bool($val)) {
				if ($type == 'boolean') {
					$val = $val ? 'true' : 'false';
				}
				else {
					if (!$val) {
						$val = 0;
					}
				}
			}
			else {
				if (is_string($val)) {
					$val = $this->expandEntities($val);
				}
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			$xml = '<' . $name . $xmlns . ' xsi:type="xsd:' . $type . '"' . $atts . '>' . $val . '</' . $name . '>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		$xml = '';
		switch (true) {
		case is_bool($val) || $type == 'boolean':
			$this->debug('serialize_val: serialize boolean');

			if ($type == 'boolean') {
				$val = $val ? 'true' : 'false';
			}
			else {
				if (!$val) {
					$val = 0;
				}
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:boolean"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_int($val) || is_long($val) || $type == 'int':
			$this->debug('serialize_val: serialize int');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:int"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_float($val) || is_double($val) || $type == 'float':
			$this->debug('serialize_val: serialize float');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:float"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_string($val) || $type == 'string':
			$this->debug('serialize_val: serialize string');
			$val = $this->expandEntities($val);

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:string"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_object($val):
			$this->debug('serialize_val: serialize object');

			if (get_class($val) == 'soapval') {
				$this->debug('serialize_val: serialize soapval object');
				$pXml = $val->serialize($use);
				$this->appendDebug($val->getDebug());
				$val->clearDebug();
			}
			else {
				if (!$name) {
					$name = get_class($val);
					$this->debug('In serialize_val, used class name ' . $name . ' as element name');
				}
				else {
					$this->debug('In serialize_val, do not override name ' . $name . ' for element name for class ' . get_class($val));
				}

				foreach (get_object_vars($val) as $k => $v) {
					$pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $pXml . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . $type_str . $atts . '>' . $pXml . '</' . $name . '>';
			}

			break;

		case is_array($val) || $type:
			$valueType = $this->isArraySimpleOrStruct($val);
			if ($valueType == 'arraySimple' || preg_match('/^ArrayOf/', $type)) {
				$this->debug('serialize_val: serialize array');
				$i = 0;
				if (is_array($val) && 0 < count($val)) {
					foreach ($val as $v) {
						if (is_object($v) && get_class($v) == 'soapval') {
							$tt_ns = $v->type_ns;
							$tt = $v->type;
						}
						else if (is_array($v)) {
							$tt = $this->isArraySimpleOrStruct($v);
						}
						else {
							$tt = gettype($v);
						}

						$array_types[$tt] = 1;
						$xml .= $this->serialize_val($v, 'item', false, false, false, false, $use);
						++$i;
					}

					if (1 < count($array_types)) {
						$array_typename = 'xsd:anyType';
					}
					else {
						if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
							if ($tt == 'integer') {
								$tt = 'int';
							}

							$array_typename = 'xsd:' . $tt;
						}
						else {
							if (isset($tt) && $tt == 'arraySimple') {
								$array_typename = 'SOAP-ENC:Array';
							}
							else {
								if (isset($tt) && $tt == 'arrayStruct') {
									$array_typename = 'unnamed_struct_use_soapval';
								}
								else {
									if ($tt_ns != '' && $tt_ns == $this->namespaces['xsd']) {
										$array_typename = 'xsd:' . $tt;
									}
									else if ($tt_ns) {
										$tt_prefix = 'ns' . rand(1000, 9999);
										$array_typename = $tt_prefix . ':' . $tt;
										$xmlns .= ' xmlns:' . $tt_prefix . '="' . $tt_ns . '"';
									}
									else {
										$array_typename = $tt;
									}
								}
							}
						}
					}

					$array_type = $i;

					if ($use == 'literal') {
						$type_str = '';
					}
					else {
						if (isset($type) && isset($type_prefix)) {
							$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
						}
						else {
							$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="' . $array_typename . ('[' . $array_type . ']"');
						}
					}
				}
				else if ($use == 'literal') {
					$type_str = '';
				}
				else {
					if (isset($type) && isset($type_prefix)) {
						$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
					}
					else {
						$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="xsd:anyType[0]"';
					}
				}

				$xml = '<' . $name . $xmlns . $type_str . $atts . '>' . $xml . ('</' . $name . '>');
			}
			else {
				$this->debug('serialize_val: serialize struct');
				if (isset($type) && isset($type_prefix)) {
					$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
				}
				else {
					$type_str = '';
				}

				if ($use == 'literal') {
					$xml .= '<' . $name . $xmlns . $atts . '>';
				}
				else {
					$xml .= '<' . $name . $xmlns . $type_str . $atts . '>';
				}

				foreach ($val as $k => $v) {
					if ($type == 'Map' && $type_ns == 'http://xml.apache.org/xml-soap') {
						$xml .= '<item>';
						$xml .= $this->serialize_val($k, 'key', false, false, false, false, $use);
						$xml .= $this->serialize_val($v, 'value', false, false, false, false, $use);
						$xml .= '</item>';
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$xml .= '</' . $name . '>';
			}

			break;

		default:
			$this->debug('serialize_val: serialize unknown');
			$xml .= 'not detected, got ' . gettype($val) . ' for ' . $val;
			break;
		}

		$this->debug('serialize_val returning ' . $xml);
		return $xml;
	}

	/**
    * serializes a message
    *
    * @param string $body the XML of the SOAP body
    * @param mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
    * @param array $namespaces optional the namespaces used in generating the body and headers
    * @param string $style optional (rpc|document)
    * @param string $use optional (encoded|literal)
    * @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
    * @return string the message
    * @access public
    */
	public function serializeEnvelope($body, $headers = false, $namespaces = array(), $style = 'rpc', $use = 'encoded', $encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/')
	{
		$this->debug('In serializeEnvelope length=' . strlen($body) . ' body (max 1000 characters)=' . substr($body, 0, 1000) . (' style=' . $style . ' use=' . $use . ' encodingStyle=' . $encodingStyle));
		$this->debug('headers:');
		$this->appendDebug($this->varDump($headers));
		$this->debug('namespaces:');
		$this->appendDebug($this->varDump($namespaces));
		$ns_string = '';

		foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
			$ns_string .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if ($encodingStyle) {
			$ns_string = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"' . $ns_string;
		}

		if ($headers) {
			if (is_array($headers)) {
				$xml = '';

				foreach ($headers as $k => $v) {
					if (is_object($v) && get_class($v) == 'soapval') {
						$xml .= $this->serialize_val($v, false, false, false, false, false, $use);
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$headers = $xml;
				$this->debug('In serializeEnvelope, serialized array of headers to ' . $headers);
			}

			$headers = '<SOAP-ENV:Header>' . $headers . '</SOAP-ENV:Header>';
		}

		return '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?' . '>' . '<SOAP-ENV:Envelope' . $ns_string . '>' . $headers . '<SOAP-ENV:Body>' . $body . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
	}

	/**
	 * formats a string to be inserted into an HTML stream
	 *
	 * @param string $str The string to format
	 * @return string The formatted string
	 * @access public
	 * @deprecated
	 */
	public function formatDump($str)
	{
		$str = htmlspecialchars($str);
		return nl2br($str);
	}

	/**
	* contracts (changes namespace to prefix) a qualified name
	*
	* @param    string $qname qname
	* @return	string contracted qname
	* @access   private
	*/
	public function contractQname($qname)
	{
		if (strrpos($qname, ':')) {
			$name = substr($qname, strrpos($qname, ':') + 1);
			$ns = substr($qname, 0, strrpos($qname, ':'));
			$p = $this->getPrefixFromNamespace($ns);

			if ($p) {
				return $p . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
	* expands (changes prefix to namespace) a qualified name
	*
	* @param    string $qname qname
	* @return	string expanded qname
	* @access   private
	*/
	public function expandQname($qname)
	{
		if (strpos($qname, ':') && !preg_match('/^http:\\/\\//', $qname)) {
			$name = substr(strstr($qname, ':'), 1);
			$prefix = substr($qname, 0, strpos($qname, ':'));

			if (isset($this->namespaces[$prefix])) {
				return $this->namespaces[$prefix] . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
    * returns the local part of a prefixed string
    * returns the original string, if not prefixed
    *
    * @param string $str The prefixed string
    * @return string The local part
    * @access public
    */
	public function getLocalPart($str)
	{
		if ($sstr = strrchr($str, ':')) {
			return substr($sstr, 1);
		}

		return $str;
	}

	/**
    * returns the prefix part of a prefixed string
    * returns false, if not prefixed
    *
    * @param string $str The prefixed string
    * @return mixed The prefix or false if there is no prefix
    * @access public
    */
	public function getPrefix($str)
	{
		if ($pos = strrpos($str, ':')) {
			return substr($str, 0, $pos);
		}

		return false;
	}

	/**
    * pass it a prefix, it returns a namespace
    *
    * @param string $prefix The prefix
    * @return mixed The namespace, false if no namespace has the specified prefix
    * @access public
    */
	public function getNamespaceFromPrefix($prefix)
	{
		if (isset($this->namespaces[$prefix])) {
			return $this->namespaces[$prefix];
		}

		return false;
	}

	/**
    * returns the prefix for a given namespace (or prefix)
    * or false if no prefixes registered for the given namespace
    *
    * @param string $ns The namespace
    * @return mixed The prefix, false if the namespace has no prefixes
    * @access public
    */
	public function getPrefixFromNamespace($ns)
	{
		foreach ($this->namespaces as $p => $n) {
			if ($ns == $n || $ns == $p) {
				$this->usedNamespaces[$p] = $n;
				return $p;
			}
		}

		return false;
	}

	/**
    * returns the time in ODBC canonical form with microseconds
    *
    * @return string The time in ODBC canonical form with microseconds
    * @access public
    */
	public function getmicrotime()
	{
		if (function_exists('gettimeofday')) {
			$tod = gettimeofday();
			$sec = $tod['sec'];
			$usec = $tod['usec'];
		}
		else {
			$sec = time();
			$usec = 0;
		}

		return strftime('%Y-%m-%d %H:%M:%S', $sec) . '.' . sprintf('%06d', $usec);
	}

	/**
	 * Returns a string with the output of var_dump
	 *
	 * @param mixed $data The variable to var_dump
	 * @return string The output of var_dump
	 * @access public
	 */
	public function varDump($data)
	{
		ob_start();
		var_dump($data);
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	/**
	* represents the object as a string
	*
	* @return	string
	* @access   public
	*/
	public function __toString()
	{
		return $this->varDump($this);
	}
}

class nusoap_fault extends nusoap_base
{
	/**
	 * The fault code (client|server)
	 * @var string
	 * @access private
	 */
	public $faultcode;
	/**
	 * The fault actor
	 * @var string
	 * @access private
	 */
	public $faultactor;
	/**
	 * The fault string, a description of the fault
	 * @var string
	 * @access private
	 */
	public $faultstring;
	/**
	 * The fault detail, typically a string or array of string
	 * @var mixed
	 * @access private
	 */
	public $faultdetail;
	/**
	 * Identification for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $title = 'NuSOAP';
	/**
	 * Version for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $version = '0.9.5';
	/**
	 * CVS revision for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $revision = '$Revision: 1.123 $';
	/**
     * Current error string (manipulated by getError/setError)
	 *
	 * @var string
	 * @access private
	 */
	public $error_str = '';
	/**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
	 *
	 * @var string
	 * @access private
	 */
	public $debug_str = '';
	/**
	 * toggles automatic encoding of special characters as entities
	 * (should always be true, I think)
	 *
	 * @var boolean
	 * @access private
	 */
	public $charencoding = true;
	/**
	 * the debug level for this instance
	 *
	 * @var	integer
	 * @access private
	 */
	public $debugLevel;
	/**
	* set schema version
	*
	* @var      string
	* @access   public
	*/
	public $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';
	/**
	* charset encoding for outgoing messages
	*
	* @var      string
	* @access   public
	*/
	public $soap_defencoding = 'ISO-8859-1';
	/**
	* namespaces in an array of prefix => uri
	*
	* this is "seeded" by a set of constants, but it may be altered by code
	*
	* @var      array
	* @access   public
	*/
	public $namespaces = array('SOAP-ENV' => 'http://schemas.xmlsoap.org/soap/envelope/', 'xsd' => 'http://www.w3.org/2001/XMLSchema', 'xsi' => 'http://www.w3.org/2001/XMLSchema-instance', 'SOAP-ENC' => 'http://schemas.xmlsoap.org/soap/encoding/');
	/**
	* namespaces used in the current context, e.g. during serialization
	*
	* @var      array
	* @access   private
	*/
	public $usedNamespaces = array();
	/**
	* XML Schema types in an array of uri => (array of xml type => php type)
	* is this legacy yet?
	* no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
	* @var      array
	* @access   public
	*/
	public $typemap = array(
		'http://www.w3.org/2001/XMLSchema'          => array('string' => 'string', 'boolean' => 'boolean', 'float' => 'double', 'double' => 'double', 'decimal' => 'double', 'duration' => '', 'dateTime' => 'string', 'time' => 'string', 'date' => 'string', 'gYearMonth' => '', 'gYear' => '', 'gMonthDay' => '', 'gDay' => '', 'gMonth' => '', 'hexBinary' => 'string', 'base64Binary' => 'string', 'anyType' => 'string', 'anySimpleType' => 'string', 'normalizedString' => 'string', 'token' => 'string', 'language' => '', 'NMTOKEN' => '', 'NMTOKENS' => '', 'Name' => '', 'NCName' => '', 'ID' => '', 'IDREF' => '', 'IDREFS' => '', 'ENTITY' => '', 'ENTITIES' => '', 'integer' => 'integer', 'nonPositiveInteger' => 'integer', 'negativeInteger' => 'integer', 'long' => 'integer', 'int' => 'integer', 'short' => 'integer', 'byte' => 'integer', 'nonNegativeInteger' => 'integer', 'unsignedLong' => '', 'unsignedInt' => '', 'unsignedShort' => '', 'unsignedByte' => '', 'positiveInteger' => ''),
		'http://www.w3.org/2000/10/XMLSchema'       => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://www.w3.org/1999/XMLSchema'          => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://soapinterop.org/xsd'                => array('SOAPStruct' => 'struct'),
		'http://schemas.xmlsoap.org/soap/encoding/' => array('base64' => 'string', 'array' => 'array', 'Array' => 'array'),
		'http://xml.apache.org/xml-soap'            => array('Map')
		);
	/**
	* XML entities to convert
	*
	* @var      array
	* @access   public
	* @deprecated
	* @see	expandEntities
	*/
	public $xmlEntities = array('quot' => '"', 'amp' => '&', 'lt' => '<', 'gt' => '>', 'apos' => '\'');

	/**
	* constructor
    *
    * @param string $faultcode (SOAP-ENV:Client | SOAP-ENV:Server)
    * @param string $faultactor only used when msg routed between multiple actors
    * @param string $faultstring human readable error message
    * @param mixed $faultdetail detail, typically a string or array of string
	*/
	public function nusoap_fault($faultcode, $faultactor = '', $faultstring = '', $faultdetail = '')
	{
		parent::nusoap_base();
		$this->faultcode = $faultcode;
		$this->faultactor = $faultactor;
		$this->faultstring = $faultstring;
		$this->faultdetail = $faultdetail;
	}

	/**
	* serialize a fault
	*
	* @return	string	The serialization of the fault instance.
	* @access   public
	*/
	public function serialize()
	{
		$ns_string = '';

		foreach ($this->namespaces as $k => $v) {
			$ns_string .= "\n  xmlns:" . $k . '="' . $v . '"';
		}

		$return_msg = '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?>' . '<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"' . $ns_string . ">\n" . '<SOAP-ENV:Body>' . '<SOAP-ENV:Fault>' . $this->serialize_val($this->faultcode, 'faultcode') . $this->serialize_val($this->faultactor, 'faultactor') . $this->serialize_val($this->faultstring, 'faultstring') . $this->serialize_val($this->faultdetail, 'detail') . '</SOAP-ENV:Fault>' . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
		return $return_msg;
	}

	/**
	* constructor
	*
	* @access	public
	*/
	public function nusoap_base()
	{
		$this->debugLevel = $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* gets the global debug level, which applies to future instances
	*
	* @return	integer	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getGlobalDebugLevel()
	{
		return $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* sets the global debug level, which applies to future instances
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setGlobalDebugLevel($level)
	{
		$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = $level;
	}

	/**
	* gets the debug level for this instance
	*
	* @return	int	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}

	/**
	* sets the debug level for this instance
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}

	/**
	* adds debug data to the instance debug string with formatting
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function debug($string)
	{
		if (0 < $this->debugLevel) {
			$this->appendDebug($this->getmicrotime() . ' ' . get_class($this) . (': ' . $string . "\n"));
		}
	}

	/**
	* adds debug data to the instance debug string without formatting
	*
	* @param    string $string debug data
	* @access   public
	*/
	public function appendDebug($string)
	{
		if (0 < $this->debugLevel) {
			$this->debug_str .= $string;
		}
	}

	/**
	* clears the current debug data for this instance
	*
	* @access   public
	*/
	public function clearDebug()
	{
		$this->debug_str = '';
	}

	/**
	* gets the current debug data for this instance
	*
	* @return   debug data
	* @access   public
	*/
	public function& getDebug()
	{
		return $this->debug_str;
	}

	/**
	* gets the current debug data for this instance as an XML comment
	* this may change the contents of the debug data
	*
	* @return   debug data as an XML comment
	* @access   public
	*/
	public function& getDebugAsXMLComment()
	{
		while (strpos($this->debug_str, '--')) {
			$this->debug_str = str_replace('--', '- -', $this->debug_str);
		}

		$ret = "<!--\n" . $this->debug_str . "\n-->";
		return $ret;
	}

	/**
	* expands entities, e.g. changes '<' to '&lt;'.
	*
	* @param	string	$val	The string in which to expand entities.
	* @access	private
	*/
	public function expandEntities($val)
	{
		if ($this->charencoding) {
			$val = str_replace('&', '&amp;', $val);
			$val = str_replace('\'', '&apos;', $val);
			$val = str_replace('"', '&quot;', $val);
			$val = str_replace('<', '&lt;', $val);
			$val = str_replace('>', '&gt;', $val);
		}

		return $val;
	}

	/**
	* returns error string if present
	*
	* @return   mixed error string or false
	* @access   public
	*/
	public function getError()
	{
		if ($this->error_str != '') {
			return $this->error_str;
		}

		return false;
	}

	/**
	* sets error string
	*
	* @return   boolean $string error string
	* @access   private
	*/
	public function setError($str)
	{
		$this->error_str = $str;
	}

	/**
	* detect if array is a simple array or a struct (associative array)
	*
	* @param	mixed	$val	The PHP array
	* @return	string	(arraySimple|arrayStruct)
	* @access	private
	*/
	public function isArraySimpleOrStruct($val)
	{
		$keyList = array_keys($val);

		foreach ($keyList as $keyListValue) {
			if (!is_int($keyListValue)) {
				return 'arrayStruct';
			}
		}

		return 'arraySimple';
	}

	/**
	* serializes PHP values in accordance w/ section 5. Type information is
	* not serialized if $use == 'literal'.
	*
	* @param	mixed	$val	The value to serialize
	* @param	string	$name	The name (local part) of the XML element
	* @param	string	$type	The XML schema type (local part) for the element
	* @param	string	$name_ns	The namespace for the name of the XML element
	* @param	string	$type_ns	The namespace for the type of the element
	* @param	array	$attributes	The attributes to serialize as name=>value pairs
	* @param	string	$use	The WSDL "use" (encoded|literal)
	* @param	boolean	$soapval	Whether this is called from soapval.
	* @return	string	The serialized element, possibly with child elements
    * @access	public
	*/
	public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = 'encoded', $soapval = false)
	{
		$this->debug('in serialize_val: name=' . $name . ', type=' . $type . ', name_ns=' . $name_ns . ', type_ns=' . $type_ns . ', use=' . $use . ', soapval=' . $soapval);
		$this->appendDebug('value=' . $this->varDump($val));
		$this->appendDebug('attributes=' . $this->varDump($attributes));
		if (is_object($val) && get_class($val) == 'soapval' && !$soapval) {
			$this->debug('serialize_val: serialize soapval');
			$xml = $val->serialize($use);
			$this->appendDebug($val->getDebug());
			$val->clearDebug();
			$this->debug('serialize_val of soapval returning ' . $xml);
			return $xml;
		}

		if (is_numeric($name)) {
			$name = '__numeric_' . $name;
		}
		else {
			if (!$name) {
				$name = 'noname';
			}
		}

		$xmlns = '';

		if ($name_ns) {
			$prefix = 'nu' . rand(1000, 9999);
			$name = $prefix . ':' . $name;
			$xmlns .= ' xmlns:' . $prefix . '="' . $name_ns . '"';
		}

		if ($type_ns != '' && $type_ns == $this->namespaces['xsd']) {
			$type_prefix = 'xsd';
		}
		else {
			if ($type_ns) {
				$type_prefix = 'ns' . rand(1000, 9999);
				$xmlns .= ' xmlns:' . $type_prefix . '="' . $type_ns . '"';
			}
		}

		$atts = '';

		if ($attributes) {
			foreach ($attributes as $k => $v) {
				$atts .= ' ' . $k . '="' . $this->expandEntities($v) . '"';
			}
		}

		if (is_null($val)) {
			$this->debug('serialize_val: serialize null');

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '/>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			$xml = '<' . $name . $xmlns . $type_str . $atts . ' xsi:nil="true"/>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		if ($type != '' && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
			$this->debug('serialize_val: serialize xsd built-in primitive type');

			if (is_bool($val)) {
				if ($type == 'boolean') {
					$val = $val ? 'true' : 'false';
				}
				else {
					if (!$val) {
						$val = 0;
					}
				}
			}
			else {
				if (is_string($val)) {
					$val = $this->expandEntities($val);
				}
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			$xml = '<' . $name . $xmlns . ' xsi:type="xsd:' . $type . '"' . $atts . '>' . $val . '</' . $name . '>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		$xml = '';
		switch (true) {
		case is_bool($val) || $type == 'boolean':
			$this->debug('serialize_val: serialize boolean');

			if ($type == 'boolean') {
				$val = $val ? 'true' : 'false';
			}
			else {
				if (!$val) {
					$val = 0;
				}
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:boolean"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_int($val) || is_long($val) || $type == 'int':
			$this->debug('serialize_val: serialize int');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:int"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_float($val) || is_double($val) || $type == 'float':
			$this->debug('serialize_val: serialize float');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:float"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_string($val) || $type == 'string':
			$this->debug('serialize_val: serialize string');
			$val = $this->expandEntities($val);

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:string"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_object($val):
			$this->debug('serialize_val: serialize object');

			if (get_class($val) == 'soapval') {
				$this->debug('serialize_val: serialize soapval object');
				$pXml = $val->serialize($use);
				$this->appendDebug($val->getDebug());
				$val->clearDebug();
			}
			else {
				if (!$name) {
					$name = get_class($val);
					$this->debug('In serialize_val, used class name ' . $name . ' as element name');
				}
				else {
					$this->debug('In serialize_val, do not override name ' . $name . ' for element name for class ' . get_class($val));
				}

				foreach (get_object_vars($val) as $k => $v) {
					$pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $pXml . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . $type_str . $atts . '>' . $pXml . '</' . $name . '>';
			}

			break;

		case is_array($val) || $type:
			$valueType = $this->isArraySimpleOrStruct($val);
			if ($valueType == 'arraySimple' || preg_match('/^ArrayOf/', $type)) {
				$this->debug('serialize_val: serialize array');
				$i = 0;
				if (is_array($val) && 0 < count($val)) {
					foreach ($val as $v) {
						if (is_object($v) && get_class($v) == 'soapval') {
							$tt_ns = $v->type_ns;
							$tt = $v->type;
						}
						else if (is_array($v)) {
							$tt = $this->isArraySimpleOrStruct($v);
						}
						else {
							$tt = gettype($v);
						}

						$array_types[$tt] = 1;
						$xml .= $this->serialize_val($v, 'item', false, false, false, false, $use);
						++$i;
					}

					if (1 < count($array_types)) {
						$array_typename = 'xsd:anyType';
					}
					else {
						if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
							if ($tt == 'integer') {
								$tt = 'int';
							}

							$array_typename = 'xsd:' . $tt;
						}
						else {
							if (isset($tt) && $tt == 'arraySimple') {
								$array_typename = 'SOAP-ENC:Array';
							}
							else {
								if (isset($tt) && $tt == 'arrayStruct') {
									$array_typename = 'unnamed_struct_use_soapval';
								}
								else {
									if ($tt_ns != '' && $tt_ns == $this->namespaces['xsd']) {
										$array_typename = 'xsd:' . $tt;
									}
									else if ($tt_ns) {
										$tt_prefix = 'ns' . rand(1000, 9999);
										$array_typename = $tt_prefix . ':' . $tt;
										$xmlns .= ' xmlns:' . $tt_prefix . '="' . $tt_ns . '"';
									}
									else {
										$array_typename = $tt;
									}
								}
							}
						}
					}

					$array_type = $i;

					if ($use == 'literal') {
						$type_str = '';
					}
					else {
						if (isset($type) && isset($type_prefix)) {
							$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
						}
						else {
							$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="' . $array_typename . ('[' . $array_type . ']"');
						}
					}
				}
				else if ($use == 'literal') {
					$type_str = '';
				}
				else {
					if (isset($type) && isset($type_prefix)) {
						$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
					}
					else {
						$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="xsd:anyType[0]"';
					}
				}

				$xml = '<' . $name . $xmlns . $type_str . $atts . '>' . $xml . ('</' . $name . '>');
			}
			else {
				$this->debug('serialize_val: serialize struct');
				if (isset($type) && isset($type_prefix)) {
					$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
				}
				else {
					$type_str = '';
				}

				if ($use == 'literal') {
					$xml .= '<' . $name . $xmlns . $atts . '>';
				}
				else {
					$xml .= '<' . $name . $xmlns . $type_str . $atts . '>';
				}

				foreach ($val as $k => $v) {
					if ($type == 'Map' && $type_ns == 'http://xml.apache.org/xml-soap') {
						$xml .= '<item>';
						$xml .= $this->serialize_val($k, 'key', false, false, false, false, $use);
						$xml .= $this->serialize_val($v, 'value', false, false, false, false, $use);
						$xml .= '</item>';
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$xml .= '</' . $name . '>';
			}

			break;

		default:
			$this->debug('serialize_val: serialize unknown');
			$xml .= 'not detected, got ' . gettype($val) . ' for ' . $val;
			break;
		}

		$this->debug('serialize_val returning ' . $xml);
		return $xml;
	}

	/**
    * serializes a message
    *
    * @param string $body the XML of the SOAP body
    * @param mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
    * @param array $namespaces optional the namespaces used in generating the body and headers
    * @param string $style optional (rpc|document)
    * @param string $use optional (encoded|literal)
    * @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
    * @return string the message
    * @access public
    */
	public function serializeEnvelope($body, $headers = false, $namespaces = array(), $style = 'rpc', $use = 'encoded', $encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/')
	{
		$this->debug('In serializeEnvelope length=' . strlen($body) . ' body (max 1000 characters)=' . substr($body, 0, 1000) . (' style=' . $style . ' use=' . $use . ' encodingStyle=' . $encodingStyle));
		$this->debug('headers:');
		$this->appendDebug($this->varDump($headers));
		$this->debug('namespaces:');
		$this->appendDebug($this->varDump($namespaces));
		$ns_string = '';

		foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
			$ns_string .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if ($encodingStyle) {
			$ns_string = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"' . $ns_string;
		}

		if ($headers) {
			if (is_array($headers)) {
				$xml = '';

				foreach ($headers as $k => $v) {
					if (is_object($v) && get_class($v) == 'soapval') {
						$xml .= $this->serialize_val($v, false, false, false, false, false, $use);
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$headers = $xml;
				$this->debug('In serializeEnvelope, serialized array of headers to ' . $headers);
			}

			$headers = '<SOAP-ENV:Header>' . $headers . '</SOAP-ENV:Header>';
		}

		return '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?' . '>' . '<SOAP-ENV:Envelope' . $ns_string . '>' . $headers . '<SOAP-ENV:Body>' . $body . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
	}

	/**
	 * formats a string to be inserted into an HTML stream
	 *
	 * @param string $str The string to format
	 * @return string The formatted string
	 * @access public
	 * @deprecated
	 */
	public function formatDump($str)
	{
		$str = htmlspecialchars($str);
		return nl2br($str);
	}

	/**
	* contracts (changes namespace to prefix) a qualified name
	*
	* @param    string $qname qname
	* @return	string contracted qname
	* @access   private
	*/
	public function contractQname($qname)
	{
		if (strrpos($qname, ':')) {
			$name = substr($qname, strrpos($qname, ':') + 1);
			$ns = substr($qname, 0, strrpos($qname, ':'));
			$p = $this->getPrefixFromNamespace($ns);

			if ($p) {
				return $p . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
	* expands (changes prefix to namespace) a qualified name
	*
	* @param    string $qname qname
	* @return	string expanded qname
	* @access   private
	*/
	public function expandQname($qname)
	{
		if (strpos($qname, ':') && !preg_match('/^http:\\/\\//', $qname)) {
			$name = substr(strstr($qname, ':'), 1);
			$prefix = substr($qname, 0, strpos($qname, ':'));

			if (isset($this->namespaces[$prefix])) {
				return $this->namespaces[$prefix] . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
    * returns the local part of a prefixed string
    * returns the original string, if not prefixed
    *
    * @param string $str The prefixed string
    * @return string The local part
    * @access public
    */
	public function getLocalPart($str)
	{
		if ($sstr = strrchr($str, ':')) {
			return substr($sstr, 1);
		}

		return $str;
	}

	/**
    * returns the prefix part of a prefixed string
    * returns false, if not prefixed
    *
    * @param string $str The prefixed string
    * @return mixed The prefix or false if there is no prefix
    * @access public
    */
	public function getPrefix($str)
	{
		if ($pos = strrpos($str, ':')) {
			return substr($str, 0, $pos);
		}

		return false;
	}

	/**
    * pass it a prefix, it returns a namespace
    *
    * @param string $prefix The prefix
    * @return mixed The namespace, false if no namespace has the specified prefix
    * @access public
    */
	public function getNamespaceFromPrefix($prefix)
	{
		if (isset($this->namespaces[$prefix])) {
			return $this->namespaces[$prefix];
		}

		return false;
	}

	/**
    * returns the prefix for a given namespace (or prefix)
    * or false if no prefixes registered for the given namespace
    *
    * @param string $ns The namespace
    * @return mixed The prefix, false if the namespace has no prefixes
    * @access public
    */
	public function getPrefixFromNamespace($ns)
	{
		foreach ($this->namespaces as $p => $n) {
			if ($ns == $n || $ns == $p) {
				$this->usedNamespaces[$p] = $n;
				return $p;
			}
		}

		return false;
	}

	/**
    * returns the time in ODBC canonical form with microseconds
    *
    * @return string The time in ODBC canonical form with microseconds
    * @access public
    */
	public function getmicrotime()
	{
		if (function_exists('gettimeofday')) {
			$tod = gettimeofday();
			$sec = $tod['sec'];
			$usec = $tod['usec'];
		}
		else {
			$sec = time();
			$usec = 0;
		}

		return strftime('%Y-%m-%d %H:%M:%S', $sec) . '.' . sprintf('%06d', $usec);
	}

	/**
	 * Returns a string with the output of var_dump
	 *
	 * @param mixed $data The variable to var_dump
	 * @return string The output of var_dump
	 * @access public
	 */
	public function varDump($data)
	{
		ob_start();
		var_dump($data);
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	/**
	* represents the object as a string
	*
	* @return	string
	* @access   public
	*/
	public function __toString()
	{
		return $this->varDump($this);
	}
}

class soap_fault extends nusoap_fault
{
	/**
	 * The fault code (client|server)
	 * @var string
	 * @access private
	 */
	public $faultcode;
	/**
	 * The fault actor
	 * @var string
	 * @access private
	 */
	public $faultactor;
	/**
	 * The fault string, a description of the fault
	 * @var string
	 * @access private
	 */
	public $faultstring;
	/**
	 * The fault detail, typically a string or array of string
	 * @var mixed
	 * @access private
	 */
	public $faultdetail;
	/**
	 * Identification for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $title = 'NuSOAP';
	/**
	 * Version for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $version = '0.9.5';
	/**
	 * CVS revision for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $revision = '$Revision: 1.123 $';
	/**
     * Current error string (manipulated by getError/setError)
	 *
	 * @var string
	 * @access private
	 */
	public $error_str = '';
	/**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
	 *
	 * @var string
	 * @access private
	 */
	public $debug_str = '';
	/**
	 * toggles automatic encoding of special characters as entities
	 * (should always be true, I think)
	 *
	 * @var boolean
	 * @access private
	 */
	public $charencoding = true;
	/**
	 * the debug level for this instance
	 *
	 * @var	integer
	 * @access private
	 */
	public $debugLevel;
	/**
	* set schema version
	*
	* @var      string
	* @access   public
	*/
	public $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';
	/**
	* charset encoding for outgoing messages
	*
	* @var      string
	* @access   public
	*/
	public $soap_defencoding = 'ISO-8859-1';
	/**
	* namespaces in an array of prefix => uri
	*
	* this is "seeded" by a set of constants, but it may be altered by code
	*
	* @var      array
	* @access   public
	*/
	public $namespaces = array('SOAP-ENV' => 'http://schemas.xmlsoap.org/soap/envelope/', 'xsd' => 'http://www.w3.org/2001/XMLSchema', 'xsi' => 'http://www.w3.org/2001/XMLSchema-instance', 'SOAP-ENC' => 'http://schemas.xmlsoap.org/soap/encoding/');
	/**
	* namespaces used in the current context, e.g. during serialization
	*
	* @var      array
	* @access   private
	*/
	public $usedNamespaces = array();
	/**
	* XML Schema types in an array of uri => (array of xml type => php type)
	* is this legacy yet?
	* no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
	* @var      array
	* @access   public
	*/
	public $typemap = array(
		'http://www.w3.org/2001/XMLSchema'          => array('string' => 'string', 'boolean' => 'boolean', 'float' => 'double', 'double' => 'double', 'decimal' => 'double', 'duration' => '', 'dateTime' => 'string', 'time' => 'string', 'date' => 'string', 'gYearMonth' => '', 'gYear' => '', 'gMonthDay' => '', 'gDay' => '', 'gMonth' => '', 'hexBinary' => 'string', 'base64Binary' => 'string', 'anyType' => 'string', 'anySimpleType' => 'string', 'normalizedString' => 'string', 'token' => 'string', 'language' => '', 'NMTOKEN' => '', 'NMTOKENS' => '', 'Name' => '', 'NCName' => '', 'ID' => '', 'IDREF' => '', 'IDREFS' => '', 'ENTITY' => '', 'ENTITIES' => '', 'integer' => 'integer', 'nonPositiveInteger' => 'integer', 'negativeInteger' => 'integer', 'long' => 'integer', 'int' => 'integer', 'short' => 'integer', 'byte' => 'integer', 'nonNegativeInteger' => 'integer', 'unsignedLong' => '', 'unsignedInt' => '', 'unsignedShort' => '', 'unsignedByte' => '', 'positiveInteger' => ''),
		'http://www.w3.org/2000/10/XMLSchema'       => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://www.w3.org/1999/XMLSchema'          => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://soapinterop.org/xsd'                => array('SOAPStruct' => 'struct'),
		'http://schemas.xmlsoap.org/soap/encoding/' => array('base64' => 'string', 'array' => 'array', 'Array' => 'array'),
		'http://xml.apache.org/xml-soap'            => array('Map')
		);
	/**
	* XML entities to convert
	*
	* @var      array
	* @access   public
	* @deprecated
	* @see	expandEntities
	*/
	public $xmlEntities = array('quot' => '"', 'amp' => '&', 'lt' => '<', 'gt' => '>', 'apos' => '\'');

	/**
	* constructor
    *
    * @param string $faultcode (SOAP-ENV:Client | SOAP-ENV:Server)
    * @param string $faultactor only used when msg routed between multiple actors
    * @param string $faultstring human readable error message
    * @param mixed $faultdetail detail, typically a string or array of string
	*/
	public function nusoap_fault($faultcode, $faultactor = '', $faultstring = '', $faultdetail = '')
	{
		parent::nusoap_base();
		$this->faultcode = $faultcode;
		$this->faultactor = $faultactor;
		$this->faultstring = $faultstring;
		$this->faultdetail = $faultdetail;
	}

	/**
	* serialize a fault
	*
	* @return	string	The serialization of the fault instance.
	* @access   public
	*/
	public function serialize()
	{
		$ns_string = '';

		foreach ($this->namespaces as $k => $v) {
			$ns_string .= "\n  xmlns:" . $k . '="' . $v . '"';
		}

		$return_msg = '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?>' . '<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"' . $ns_string . ">\n" . '<SOAP-ENV:Body>' . '<SOAP-ENV:Fault>' . $this->serialize_val($this->faultcode, 'faultcode') . $this->serialize_val($this->faultactor, 'faultactor') . $this->serialize_val($this->faultstring, 'faultstring') . $this->serialize_val($this->faultdetail, 'detail') . '</SOAP-ENV:Fault>' . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
		return $return_msg;
	}

	/**
	* constructor
	*
	* @access	public
	*/
	public function nusoap_base()
	{
		$this->debugLevel = $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* gets the global debug level, which applies to future instances
	*
	* @return	integer	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getGlobalDebugLevel()
	{
		return $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* sets the global debug level, which applies to future instances
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setGlobalDebugLevel($level)
	{
		$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = $level;
	}

	/**
	* gets the debug level for this instance
	*
	* @return	int	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}

	/**
	* sets the debug level for this instance
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}

	/**
	* adds debug data to the instance debug string with formatting
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function debug($string)
	{
		if (0 < $this->debugLevel) {
			$this->appendDebug($this->getmicrotime() . ' ' . get_class($this) . (': ' . $string . "\n"));
		}
	}

	/**
	* adds debug data to the instance debug string without formatting
	*
	* @param    string $string debug data
	* @access   public
	*/
	public function appendDebug($string)
	{
		if (0 < $this->debugLevel) {
			$this->debug_str .= $string;
		}
	}

	/**
	* clears the current debug data for this instance
	*
	* @access   public
	*/
	public function clearDebug()
	{
		$this->debug_str = '';
	}

	/**
	* gets the current debug data for this instance
	*
	* @return   debug data
	* @access   public
	*/
	public function& getDebug()
	{
		return $this->debug_str;
	}

	/**
	* gets the current debug data for this instance as an XML comment
	* this may change the contents of the debug data
	*
	* @return   debug data as an XML comment
	* @access   public
	*/
	public function& getDebugAsXMLComment()
	{
		while (strpos($this->debug_str, '--')) {
			$this->debug_str = str_replace('--', '- -', $this->debug_str);
		}

		$ret = "<!--\n" . $this->debug_str . "\n-->";
		return $ret;
	}

	/**
	* expands entities, e.g. changes '<' to '&lt;'.
	*
	* @param	string	$val	The string in which to expand entities.
	* @access	private
	*/
	public function expandEntities($val)
	{
		if ($this->charencoding) {
			$val = str_replace('&', '&amp;', $val);
			$val = str_replace('\'', '&apos;', $val);
			$val = str_replace('"', '&quot;', $val);
			$val = str_replace('<', '&lt;', $val);
			$val = str_replace('>', '&gt;', $val);
		}

		return $val;
	}

	/**
	* returns error string if present
	*
	* @return   mixed error string or false
	* @access   public
	*/
	public function getError()
	{
		if ($this->error_str != '') {
			return $this->error_str;
		}

		return false;
	}

	/**
	* sets error string
	*
	* @return   boolean $string error string
	* @access   private
	*/
	public function setError($str)
	{
		$this->error_str = $str;
	}

	/**
	* detect if array is a simple array or a struct (associative array)
	*
	* @param	mixed	$val	The PHP array
	* @return	string	(arraySimple|arrayStruct)
	* @access	private
	*/
	public function isArraySimpleOrStruct($val)
	{
		$keyList = array_keys($val);

		foreach ($keyList as $keyListValue) {
			if (!is_int($keyListValue)) {
				return 'arrayStruct';
			}
		}

		return 'arraySimple';
	}

	/**
	* serializes PHP values in accordance w/ section 5. Type information is
	* not serialized if $use == 'literal'.
	*
	* @param	mixed	$val	The value to serialize
	* @param	string	$name	The name (local part) of the XML element
	* @param	string	$type	The XML schema type (local part) for the element
	* @param	string	$name_ns	The namespace for the name of the XML element
	* @param	string	$type_ns	The namespace for the type of the element
	* @param	array	$attributes	The attributes to serialize as name=>value pairs
	* @param	string	$use	The WSDL "use" (encoded|literal)
	* @param	boolean	$soapval	Whether this is called from soapval.
	* @return	string	The serialized element, possibly with child elements
    * @access	public
	*/
	public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = 'encoded', $soapval = false)
	{
		$this->debug('in serialize_val: name=' . $name . ', type=' . $type . ', name_ns=' . $name_ns . ', type_ns=' . $type_ns . ', use=' . $use . ', soapval=' . $soapval);
		$this->appendDebug('value=' . $this->varDump($val));
		$this->appendDebug('attributes=' . $this->varDump($attributes));
		if (is_object($val) && get_class($val) == 'soapval' && !$soapval) {
			$this->debug('serialize_val: serialize soapval');
			$xml = $val->serialize($use);
			$this->appendDebug($val->getDebug());
			$val->clearDebug();
			$this->debug('serialize_val of soapval returning ' . $xml);
			return $xml;
		}

		if (is_numeric($name)) {
			$name = '__numeric_' . $name;
		}
		else {
			if (!$name) {
				$name = 'noname';
			}
		}

		$xmlns = '';

		if ($name_ns) {
			$prefix = 'nu' . rand(1000, 9999);
			$name = $prefix . ':' . $name;
			$xmlns .= ' xmlns:' . $prefix . '="' . $name_ns . '"';
		}

		if ($type_ns != '' && $type_ns == $this->namespaces['xsd']) {
			$type_prefix = 'xsd';
		}
		else {
			if ($type_ns) {
				$type_prefix = 'ns' . rand(1000, 9999);
				$xmlns .= ' xmlns:' . $type_prefix . '="' . $type_ns . '"';
			}
		}

		$atts = '';

		if ($attributes) {
			foreach ($attributes as $k => $v) {
				$atts .= ' ' . $k . '="' . $this->expandEntities($v) . '"';
			}
		}

		if (is_null($val)) {
			$this->debug('serialize_val: serialize null');

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '/>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			$xml = '<' . $name . $xmlns . $type_str . $atts . ' xsi:nil="true"/>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		if ($type != '' && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
			$this->debug('serialize_val: serialize xsd built-in primitive type');

			if (is_bool($val)) {
				if ($type == 'boolean') {
					$val = $val ? 'true' : 'false';
				}
				else {
					if (!$val) {
						$val = 0;
					}
				}
			}
			else {
				if (is_string($val)) {
					$val = $this->expandEntities($val);
				}
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			$xml = '<' . $name . $xmlns . ' xsi:type="xsd:' . $type . '"' . $atts . '>' . $val . '</' . $name . '>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		$xml = '';
		switch (true) {
		case is_bool($val) || $type == 'boolean':
			$this->debug('serialize_val: serialize boolean');

			if ($type == 'boolean') {
				$val = $val ? 'true' : 'false';
			}
			else {
				if (!$val) {
					$val = 0;
				}
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:boolean"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_int($val) || is_long($val) || $type == 'int':
			$this->debug('serialize_val: serialize int');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:int"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_float($val) || is_double($val) || $type == 'float':
			$this->debug('serialize_val: serialize float');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:float"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_string($val) || $type == 'string':
			$this->debug('serialize_val: serialize string');
			$val = $this->expandEntities($val);

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:string"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_object($val):
			$this->debug('serialize_val: serialize object');

			if (get_class($val) == 'soapval') {
				$this->debug('serialize_val: serialize soapval object');
				$pXml = $val->serialize($use);
				$this->appendDebug($val->getDebug());
				$val->clearDebug();
			}
			else {
				if (!$name) {
					$name = get_class($val);
					$this->debug('In serialize_val, used class name ' . $name . ' as element name');
				}
				else {
					$this->debug('In serialize_val, do not override name ' . $name . ' for element name for class ' . get_class($val));
				}

				foreach (get_object_vars($val) as $k => $v) {
					$pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $pXml . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . $type_str . $atts . '>' . $pXml . '</' . $name . '>';
			}

			break;

		case is_array($val) || $type:
			$valueType = $this->isArraySimpleOrStruct($val);
			if ($valueType == 'arraySimple' || preg_match('/^ArrayOf/', $type)) {
				$this->debug('serialize_val: serialize array');
				$i = 0;
				if (is_array($val) && 0 < count($val)) {
					foreach ($val as $v) {
						if (is_object($v) && get_class($v) == 'soapval') {
							$tt_ns = $v->type_ns;
							$tt = $v->type;
						}
						else if (is_array($v)) {
							$tt = $this->isArraySimpleOrStruct($v);
						}
						else {
							$tt = gettype($v);
						}

						$array_types[$tt] = 1;
						$xml .= $this->serialize_val($v, 'item', false, false, false, false, $use);
						++$i;
					}

					if (1 < count($array_types)) {
						$array_typename = 'xsd:anyType';
					}
					else {
						if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
							if ($tt == 'integer') {
								$tt = 'int';
							}

							$array_typename = 'xsd:' . $tt;
						}
						else {
							if (isset($tt) && $tt == 'arraySimple') {
								$array_typename = 'SOAP-ENC:Array';
							}
							else {
								if (isset($tt) && $tt == 'arrayStruct') {
									$array_typename = 'unnamed_struct_use_soapval';
								}
								else {
									if ($tt_ns != '' && $tt_ns == $this->namespaces['xsd']) {
										$array_typename = 'xsd:' . $tt;
									}
									else if ($tt_ns) {
										$tt_prefix = 'ns' . rand(1000, 9999);
										$array_typename = $tt_prefix . ':' . $tt;
										$xmlns .= ' xmlns:' . $tt_prefix . '="' . $tt_ns . '"';
									}
									else {
										$array_typename = $tt;
									}
								}
							}
						}
					}

					$array_type = $i;

					if ($use == 'literal') {
						$type_str = '';
					}
					else {
						if (isset($type) && isset($type_prefix)) {
							$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
						}
						else {
							$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="' . $array_typename . ('[' . $array_type . ']"');
						}
					}
				}
				else if ($use == 'literal') {
					$type_str = '';
				}
				else {
					if (isset($type) && isset($type_prefix)) {
						$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
					}
					else {
						$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="xsd:anyType[0]"';
					}
				}

				$xml = '<' . $name . $xmlns . $type_str . $atts . '>' . $xml . ('</' . $name . '>');
			}
			else {
				$this->debug('serialize_val: serialize struct');
				if (isset($type) && isset($type_prefix)) {
					$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
				}
				else {
					$type_str = '';
				}

				if ($use == 'literal') {
					$xml .= '<' . $name . $xmlns . $atts . '>';
				}
				else {
					$xml .= '<' . $name . $xmlns . $type_str . $atts . '>';
				}

				foreach ($val as $k => $v) {
					if ($type == 'Map' && $type_ns == 'http://xml.apache.org/xml-soap') {
						$xml .= '<item>';
						$xml .= $this->serialize_val($k, 'key', false, false, false, false, $use);
						$xml .= $this->serialize_val($v, 'value', false, false, false, false, $use);
						$xml .= '</item>';
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$xml .= '</' . $name . '>';
			}

			break;

		default:
			$this->debug('serialize_val: serialize unknown');
			$xml .= 'not detected, got ' . gettype($val) . ' for ' . $val;
			break;
		}

		$this->debug('serialize_val returning ' . $xml);
		return $xml;
	}

	/**
    * serializes a message
    *
    * @param string $body the XML of the SOAP body
    * @param mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
    * @param array $namespaces optional the namespaces used in generating the body and headers
    * @param string $style optional (rpc|document)
    * @param string $use optional (encoded|literal)
    * @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
    * @return string the message
    * @access public
    */
	public function serializeEnvelope($body, $headers = false, $namespaces = array(), $style = 'rpc', $use = 'encoded', $encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/')
	{
		$this->debug('In serializeEnvelope length=' . strlen($body) . ' body (max 1000 characters)=' . substr($body, 0, 1000) . (' style=' . $style . ' use=' . $use . ' encodingStyle=' . $encodingStyle));
		$this->debug('headers:');
		$this->appendDebug($this->varDump($headers));
		$this->debug('namespaces:');
		$this->appendDebug($this->varDump($namespaces));
		$ns_string = '';

		foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
			$ns_string .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if ($encodingStyle) {
			$ns_string = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"' . $ns_string;
		}

		if ($headers) {
			if (is_array($headers)) {
				$xml = '';

				foreach ($headers as $k => $v) {
					if (is_object($v) && get_class($v) == 'soapval') {
						$xml .= $this->serialize_val($v, false, false, false, false, false, $use);
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$headers = $xml;
				$this->debug('In serializeEnvelope, serialized array of headers to ' . $headers);
			}

			$headers = '<SOAP-ENV:Header>' . $headers . '</SOAP-ENV:Header>';
		}

		return '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?' . '>' . '<SOAP-ENV:Envelope' . $ns_string . '>' . $headers . '<SOAP-ENV:Body>' . $body . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
	}

	/**
	 * formats a string to be inserted into an HTML stream
	 *
	 * @param string $str The string to format
	 * @return string The formatted string
	 * @access public
	 * @deprecated
	 */
	public function formatDump($str)
	{
		$str = htmlspecialchars($str);
		return nl2br($str);
	}

	/**
	* contracts (changes namespace to prefix) a qualified name
	*
	* @param    string $qname qname
	* @return	string contracted qname
	* @access   private
	*/
	public function contractQname($qname)
	{
		if (strrpos($qname, ':')) {
			$name = substr($qname, strrpos($qname, ':') + 1);
			$ns = substr($qname, 0, strrpos($qname, ':'));
			$p = $this->getPrefixFromNamespace($ns);

			if ($p) {
				return $p . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
	* expands (changes prefix to namespace) a qualified name
	*
	* @param    string $qname qname
	* @return	string expanded qname
	* @access   private
	*/
	public function expandQname($qname)
	{
		if (strpos($qname, ':') && !preg_match('/^http:\\/\\//', $qname)) {
			$name = substr(strstr($qname, ':'), 1);
			$prefix = substr($qname, 0, strpos($qname, ':'));

			if (isset($this->namespaces[$prefix])) {
				return $this->namespaces[$prefix] . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
    * returns the local part of a prefixed string
    * returns the original string, if not prefixed
    *
    * @param string $str The prefixed string
    * @return string The local part
    * @access public
    */
	public function getLocalPart($str)
	{
		if ($sstr = strrchr($str, ':')) {
			return substr($sstr, 1);
		}

		return $str;
	}

	/**
    * returns the prefix part of a prefixed string
    * returns false, if not prefixed
    *
    * @param string $str The prefixed string
    * @return mixed The prefix or false if there is no prefix
    * @access public
    */
	public function getPrefix($str)
	{
		if ($pos = strrpos($str, ':')) {
			return substr($str, 0, $pos);
		}

		return false;
	}

	/**
    * pass it a prefix, it returns a namespace
    *
    * @param string $prefix The prefix
    * @return mixed The namespace, false if no namespace has the specified prefix
    * @access public
    */
	public function getNamespaceFromPrefix($prefix)
	{
		if (isset($this->namespaces[$prefix])) {
			return $this->namespaces[$prefix];
		}

		return false;
	}

	/**
    * returns the prefix for a given namespace (or prefix)
    * or false if no prefixes registered for the given namespace
    *
    * @param string $ns The namespace
    * @return mixed The prefix, false if the namespace has no prefixes
    * @access public
    */
	public function getPrefixFromNamespace($ns)
	{
		foreach ($this->namespaces as $p => $n) {
			if ($ns == $n || $ns == $p) {
				$this->usedNamespaces[$p] = $n;
				return $p;
			}
		}

		return false;
	}

	/**
    * returns the time in ODBC canonical form with microseconds
    *
    * @return string The time in ODBC canonical form with microseconds
    * @access public
    */
	public function getmicrotime()
	{
		if (function_exists('gettimeofday')) {
			$tod = gettimeofday();
			$sec = $tod['sec'];
			$usec = $tod['usec'];
		}
		else {
			$sec = time();
			$usec = 0;
		}

		return strftime('%Y-%m-%d %H:%M:%S', $sec) . '.' . sprintf('%06d', $usec);
	}

	/**
	 * Returns a string with the output of var_dump
	 *
	 * @param mixed $data The variable to var_dump
	 * @return string The output of var_dump
	 * @access public
	 */
	public function varDump($data)
	{
		ob_start();
		var_dump($data);
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	/**
	* represents the object as a string
	*
	* @return	string
	* @access   public
	*/
	public function __toString()
	{
		return $this->varDump($this);
	}
}

class nusoap_xmlschema extends nusoap_base
{
	public $schema = '';
	public $xml = '';
	public $enclosingNamespaces;
	public $schemaInfo = array();
	public $schemaTargetNamespace = '';
	public $attributes = array();
	public $complexTypes = array();
	public $complexTypeStack = array();
	public $currentComplexType;
	public $elements = array();
	public $elementStack = array();
	public $currentElement;
	public $simpleTypes = array();
	public $simpleTypeStack = array();
	public $currentSimpleType;
	public $imports = array();
	public $parser;
	public $position = 0;
	public $depth = 0;
	public $depth_array = array();
	public $message = array();
	public $defaultNamespace = array();
	/**
	 * Identification for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $title = 'NuSOAP';
	/**
	 * Version for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $version = '0.9.5';
	/**
	 * CVS revision for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $revision = '$Revision: 1.123 $';
	/**
     * Current error string (manipulated by getError/setError)
	 *
	 * @var string
	 * @access private
	 */
	public $error_str = '';
	/**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
	 *
	 * @var string
	 * @access private
	 */
	public $debug_str = '';
	/**
	 * toggles automatic encoding of special characters as entities
	 * (should always be true, I think)
	 *
	 * @var boolean
	 * @access private
	 */
	public $charencoding = true;
	/**
	 * the debug level for this instance
	 *
	 * @var	integer
	 * @access private
	 */
	public $debugLevel;
	/**
	* set schema version
	*
	* @var      string
	* @access   public
	*/
	public $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';
	/**
	* charset encoding for outgoing messages
	*
	* @var      string
	* @access   public
	*/
	public $soap_defencoding = 'ISO-8859-1';
	/**
	* namespaces in an array of prefix => uri
	*
	* this is "seeded" by a set of constants, but it may be altered by code
	*
	* @var      array
	* @access   public
	*/
	public $namespaces = array('SOAP-ENV' => 'http://schemas.xmlsoap.org/soap/envelope/', 'xsd' => 'http://www.w3.org/2001/XMLSchema', 'xsi' => 'http://www.w3.org/2001/XMLSchema-instance', 'SOAP-ENC' => 'http://schemas.xmlsoap.org/soap/encoding/');
	/**
	* namespaces used in the current context, e.g. during serialization
	*
	* @var      array
	* @access   private
	*/
	public $usedNamespaces = array();
	/**
	* XML Schema types in an array of uri => (array of xml type => php type)
	* is this legacy yet?
	* no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
	* @var      array
	* @access   public
	*/
	public $typemap = array(
		'http://www.w3.org/2001/XMLSchema'          => array('string' => 'string', 'boolean' => 'boolean', 'float' => 'double', 'double' => 'double', 'decimal' => 'double', 'duration' => '', 'dateTime' => 'string', 'time' => 'string', 'date' => 'string', 'gYearMonth' => '', 'gYear' => '', 'gMonthDay' => '', 'gDay' => '', 'gMonth' => '', 'hexBinary' => 'string', 'base64Binary' => 'string', 'anyType' => 'string', 'anySimpleType' => 'string', 'normalizedString' => 'string', 'token' => 'string', 'language' => '', 'NMTOKEN' => '', 'NMTOKENS' => '', 'Name' => '', 'NCName' => '', 'ID' => '', 'IDREF' => '', 'IDREFS' => '', 'ENTITY' => '', 'ENTITIES' => '', 'integer' => 'integer', 'nonPositiveInteger' => 'integer', 'negativeInteger' => 'integer', 'long' => 'integer', 'int' => 'integer', 'short' => 'integer', 'byte' => 'integer', 'nonNegativeInteger' => 'integer', 'unsignedLong' => '', 'unsignedInt' => '', 'unsignedShort' => '', 'unsignedByte' => '', 'positiveInteger' => ''),
		'http://www.w3.org/2000/10/XMLSchema'       => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://www.w3.org/1999/XMLSchema'          => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://soapinterop.org/xsd'                => array('SOAPStruct' => 'struct'),
		'http://schemas.xmlsoap.org/soap/encoding/' => array('base64' => 'string', 'array' => 'array', 'Array' => 'array'),
		'http://xml.apache.org/xml-soap'            => array('Map')
		);
	/**
	* XML entities to convert
	*
	* @var      array
	* @access   public
	* @deprecated
	* @see	expandEntities
	*/
	public $xmlEntities = array('quot' => '"', 'amp' => '&', 'lt' => '<', 'gt' => '>', 'apos' => '\'');

	/**
	* constructor
	*
	* @param    string $schema schema document URI
	* @param    string $xml xml document URI
	* @param	string $namespaces namespaces defined in enclosing XML
	* @access   public
	*/
	public function nusoap_xmlschema($schema = '', $xml = '', $namespaces = array())
	{
		parent::nusoap_base();
		$this->debug('nusoap_xmlschema class instantiated, inside constructor');
		$this->schema = $schema;
		$this->xml = $xml;
		$this->enclosingNamespaces = $namespaces;
		$this->namespaces = array_merge($this->namespaces, $namespaces);

		if ($schema != '') {
			$this->debug('initial schema file: ' . $schema);
			$this->parseFile($schema, 'schema');
		}

		if ($xml != '') {
			$this->debug('initial xml file: ' . $xml);
			$this->parseFile($xml, 'xml');
		}
	}

	/**
    * parse an XML file
    *
    * @param string $xml path/URL to XML file
    * @param string $type (schema | xml)
	* @return boolean
    * @access public
    */
	public function parseFile($xml, $type)
	{
		if ($xml != '') {
			$xmlStr = @join('', @file($xml));

			if ($xmlStr == '') {
				$msg = 'Error reading XML from ' . $xml;
				$this->setError($msg);
				$this->debug($msg);
				return false;
			}

			$this->debug('parsing ' . $xml);
			$this->parseString($xmlStr, $type);
			$this->debug('done parsing ' . $xml);
			return true;
		}

		return false;
	}

	/**
	* parse an XML string
	*
	* @param    string $xml path or URL
    * @param	string $type (schema|xml)
	* @access   private
	*/
	public function parseString($xml, $type)
	{
		if ($xml != '') {
			$this->parser = xml_parser_create();
			xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);
			xml_set_object($this->parser, $this);

			if ($type == 'schema') {
				xml_set_element_handler($this->parser, 'schemaStartElement', 'schemaEndElement');
				xml_set_character_data_handler($this->parser, 'schemaCharacterData');
			}
			else {
				if ($type == 'xml') {
					xml_set_element_handler($this->parser, 'xmlStartElement', 'xmlEndElement');
					xml_set_character_data_handler($this->parser, 'xmlCharacterData');
				}
			}

			if (!xml_parse($this->parser, $xml, true)) {
				$errstr = sprintf('XML error parsing XML schema on line %d: %s', xml_get_current_line_number($this->parser), xml_error_string(xml_get_error_code($this->parser)));
				$this->debug($errstr);
				$this->debug("XML payload:\n" . $xml);
				$this->setError($errstr);
			}

			xml_parser_free($this->parser);
			return NULL;
		}

		$this->debug('no xml passed to parseString()!!');
		$this->setError('no xml passed to parseString()!!');
	}

	/**
	 * gets a type name for an unnamed type
	 *
	 * @param	string	Element name
	 * @return	string	A type name for an unnamed type
	 * @access	private
	 */
	public function CreateTypeName($ename)
	{
		$scope = '';
		$i = 0;

		while ($i < count($this->complexTypeStack)) {
			$scope .= $this->complexTypeStack[$i] . '_';
			++$i;
		}

		return $scope . $ename . '_ContainedType';
	}

	/**
	* start-element handler
	*
	* @param    string $parser XML parser object
	* @param    string $name element name
	* @param    string $attrs associative array of attributes
	* @access   private
	*/
	public function schemaStartElement($parser, $name, $attrs)
	{
		$pos = $this->position++;
		$depth = $this->depth++;
		$this->depth_array[$depth] = $pos;
		$this->message[$pos] = array('cdata' => '');

		if (0 < $depth) {
			$this->defaultNamespace[$pos] = $this->defaultNamespace[$this->depth_array[$depth - 1]];
		}
		else {
			$this->defaultNamespace[$pos] = false;
		}

		if ($prefix = $this->getPrefix($name)) {
			$name = $this->getLocalPart($name);
		}
		else {
			$prefix = '';
		}

		if (0 < count($attrs)) {
			foreach ($attrs as $k => $v) {
				if (preg_match('/^xmlns/', $k)) {
					if ($ns_prefix = substr(strrchr($k, ':'), 1)) {
						$this->namespaces[$ns_prefix] = $v;
					}
					else {
						$this->defaultNamespace[$pos] = $v;

						if (!$this->getPrefixFromNamespace($v)) {
							$this->namespaces['ns' . (count($this->namespaces) + 1)] = $v;
						}
					}

					if ($v == 'http://www.w3.org/2001/XMLSchema' || $v == 'http://www.w3.org/1999/XMLSchema' || $v == 'http://www.w3.org/2000/10/XMLSchema') {
						$this->XMLSchemaVersion = $v;
						$this->namespaces['xsi'] = $v . '-instance';
					}
				}
			}

			foreach ($attrs as $k => $v) {
				$k = strpos($k, ':') ? $this->expandQname($k) : $k;
				$v = strpos($v, ':') ? $this->expandQname($v) : $v;
				$eAttrs[$k] = $v;
			}

			$attrs = $eAttrs;
		}
		else {
			$attrs = array();
		}

		switch ($name) {
		case 'all':
		case 'choice':
		case 'group':
		case 'sequence':
			$this->complexTypes[$this->currentComplexType]['compositor'] = $name;
			break;

		case 'attribute':
			$this->xdebug('parsing attribute:');
			$this->appendDebug($this->varDump($attrs));

			if (!isset($attrs['form'])) {
				$attrs['form'] = $this->schemaInfo['attributeFormDefault'];
			}

			if (isset($attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'])) {
				$v = $attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'];

				if (!strpos($v, ':')) {
					if ($this->defaultNamespace[$pos]) {
						$attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'] = $this->defaultNamespace[$pos] . ':' . $attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'];
					}
				}
			}

			if (isset($attrs['name'])) {
				$this->attributes[$attrs['name']] = $attrs;
				$aname = $attrs['name'];
			}
			else {
				if (isset($attrs['ref']) && $attrs['ref'] == 'http://schemas.xmlsoap.org/soap/encoding/:arrayType') {
					if (isset($attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'])) {
						$aname = $attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'];
					}
					else {
						$aname = '';
					}
				}
				else {
					if (isset($attrs['ref'])) {
						$aname = $attrs['ref'];
						$this->attributes[$attrs['ref']] = $attrs;
					}
				}
			}

			if ($this->currentComplexType) {
				$this->complexTypes[$this->currentComplexType]['attrs'][$aname] = $attrs;
			}

			if (isset($attrs['http://schemas.xmlsoap.org/wsdl/:arrayType']) || $this->getLocalPart($aname) == 'arrayType') {
				$this->complexTypes[$this->currentComplexType]['phpType'] = 'array';
				$prefix = $this->getPrefix($aname);

				if (isset($attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'])) {
					$v = $attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'];
				}
				else {
					$v = '';
				}

				if (strpos($v, '[,]')) {
					$this->complexTypes[$this->currentComplexType]['multidimensional'] = true;
				}

				$v = substr($v, 0, strpos($v, '['));
				if (!strpos($v, ':') && isset($this->typemap[$this->XMLSchemaVersion][$v])) {
					$v = $this->XMLSchemaVersion . ':' . $v;
				}

				$this->complexTypes[$this->currentComplexType]['arrayType'] = $v;
			}

			break;

		case 'complexContent':
			$this->xdebug('do nothing for element ' . $name);
			break;

		case 'complexType':
			array_push($this->complexTypeStack, $this->currentComplexType);

			if (isset($attrs['name'])) {
				$this->xdebug('processing named complexType ' . $attrs['name']);
				$this->currentComplexType = $attrs['name'];
				$this->complexTypes[$this->currentComplexType] = $attrs;
				$this->complexTypes[$this->currentComplexType]['typeClass'] = 'complexType';
				if (isset($attrs['base']) && preg_match('/:Array$/', $attrs['base'])) {
					$this->xdebug('complexType is unusual array');
					$this->complexTypes[$this->currentComplexType]['phpType'] = 'array';
				}
				else {
					$this->complexTypes[$this->currentComplexType]['phpType'] = 'struct';
				}
			}
			else {
				$name = $this->CreateTypeName($this->currentElement);
				$this->xdebug('processing unnamed complexType for element ' . $this->currentElement . ' named ' . $name);
				$this->currentComplexType = $name;
				$this->complexTypes[$this->currentComplexType] = $attrs;
				$this->complexTypes[$this->currentComplexType]['typeClass'] = 'complexType';
				if (isset($attrs['base']) && preg_match('/:Array$/', $attrs['base'])) {
					$this->xdebug('complexType is unusual array');
					$this->complexTypes[$this->currentComplexType]['phpType'] = 'array';
				}
				else {
					$this->complexTypes[$this->currentComplexType]['phpType'] = 'struct';
				}
			}

			$this->complexTypes[$this->currentComplexType]['simpleContent'] = 'false';
			break;

		case 'element':
			array_push($this->elementStack, $this->currentElement);

			if (!isset($attrs['form'])) {
				if ($this->currentComplexType) {
					$attrs['form'] = $this->schemaInfo['elementFormDefault'];
				}
				else {
					$attrs['form'] = 'qualified';
				}
			}

			if (isset($attrs['type'])) {
				$this->xdebug('processing typed element ' . $attrs['name'] . ' of type ' . $attrs['type']);

				if (!$this->getPrefix($attrs['type'])) {
					if ($this->defaultNamespace[$pos]) {
						$attrs['type'] = $this->defaultNamespace[$pos] . ':' . $attrs['type'];
						$this->xdebug('used default namespace to make type ' . $attrs['type']);
					}
				}

				if ($this->currentComplexType && $this->complexTypes[$this->currentComplexType]['phpType'] == 'array') {
					$this->xdebug('arrayType for unusual array is ' . $attrs['type']);
					$this->complexTypes[$this->currentComplexType]['arrayType'] = $attrs['type'];
				}

				$this->currentElement = $attrs['name'];
				$ename = $attrs['name'];
			}
			else if (isset($attrs['ref'])) {
				$this->xdebug('processing element as ref to ' . $attrs['ref']);
				$this->currentElement = 'ref to ' . $attrs['ref'];
				$ename = $this->getLocalPart($attrs['ref']);
			}
			else {
				$type = $this->CreateTypeName($this->currentComplexType . '_' . $attrs['name']);
				$this->xdebug('processing untyped element ' . $attrs['name'] . ' type ' . $type);
				$this->currentElement = $attrs['name'];
				$attrs['type'] = $this->schemaTargetNamespace . ':' . $type;
				$ename = $attrs['name'];
			}

			if (isset($ename) && $this->currentComplexType) {
				$this->xdebug('add element ' . $ename . ' to complexType ' . $this->currentComplexType);
				$this->complexTypes[$this->currentComplexType]['elements'][$ename] = $attrs;
			}
			else {
				if (!isset($attrs['ref'])) {
					$this->xdebug('add element ' . $ename . ' to elements array');
					$this->elements[$attrs['name']] = $attrs;
					$this->elements[$attrs['name']]['typeClass'] = 'element';
				}
			}

			break;

		case 'enumeration':
			$this->xdebug('enumeration ' . $attrs['value']);

			if ($this->currentSimpleType) {
				$this->simpleTypes[$this->currentSimpleType]['enumeration'][] = $attrs['value'];
			}
			else {
				if ($this->currentComplexType) {
					$this->complexTypes[$this->currentComplexType]['enumeration'][] = $attrs['value'];
				}
			}

			break;

		case 'extension':
			$this->xdebug('extension ' . $attrs['base']);

			if ($this->currentComplexType) {
				$ns = $this->getPrefix($attrs['base']);

				if ($ns == '') {
					$this->complexTypes[$this->currentComplexType]['extensionBase'] = $this->schemaTargetNamespace . ':' . $attrs['base'];
				}
				else {
					$this->complexTypes[$this->currentComplexType]['extensionBase'] = $attrs['base'];
				}
			}
			else {
				$this->xdebug('no current complexType to set extensionBase');
			}

			break;

		case 'import':
			if (isset($attrs['schemaLocation'])) {
				$this->xdebug('import namespace ' . $attrs['namespace'] . ' from ' . $attrs['schemaLocation']);
				$this->imports[$attrs['namespace']][] = array('location' => $attrs['schemaLocation'], 'loaded' => false);
			}
			else {
				$this->xdebug('import namespace ' . $attrs['namespace']);
				$this->imports[$attrs['namespace']][] = array('location' => '', 'loaded' => true);

				if (!$this->getPrefixFromNamespace($attrs['namespace'])) {
					$this->namespaces['ns' . (count($this->namespaces) + 1)] = $attrs['namespace'];
				}
			}

			break;

		case 'include':
			if (isset($attrs['schemaLocation'])) {
				$this->xdebug('include into namespace ' . $this->schemaTargetNamespace . ' from ' . $attrs['schemaLocation']);
				$this->imports[$this->schemaTargetNamespace][] = array('location' => $attrs['schemaLocation'], 'loaded' => false);
			}
			else {
				$this->xdebug('ignoring invalid XML Schema construct: include without schemaLocation attribute');
			}

			break;

		case 'list':
			$this->xdebug('do nothing for element ' . $name);
			break;

		case 'restriction':
			$this->xdebug('restriction ' . $attrs['base']);

			if ($this->currentSimpleType) {
				$this->simpleTypes[$this->currentSimpleType]['type'] = $attrs['base'];
			}
			else {
				if ($this->currentComplexType) {
					$this->complexTypes[$this->currentComplexType]['restrictionBase'] = $attrs['base'];

					if (strstr($attrs['base'], ':') == ':Array') {
						$this->complexTypes[$this->currentComplexType]['phpType'] = 'array';
					}
				}
			}

			break;

		case 'schema':
			$this->schemaInfo = $attrs;
			$this->schemaInfo['schemaVersion'] = $this->getNamespaceFromPrefix($prefix);

			if (isset($attrs['targetNamespace'])) {
				$this->schemaTargetNamespace = $attrs['targetNamespace'];
			}

			if (!isset($attrs['elementFormDefault'])) {
				$this->schemaInfo['elementFormDefault'] = 'unqualified';
			}

			if (!isset($attrs['attributeFormDefault'])) {
				$this->schemaInfo['attributeFormDefault'] = 'unqualified';
			}

			break;

		case 'simpleContent':
			if ($this->currentComplexType) {
				$this->complexTypes[$this->currentComplexType]['simpleContent'] = 'true';
			}
			else {
				$this->xdebug('do nothing for element ' . $name . ' because there is no current complexType');
			}

			break;

		case 'simpleType':
			array_push($this->simpleTypeStack, $this->currentSimpleType);

			if (isset($attrs['name'])) {
				$this->xdebug('processing simpleType for name ' . $attrs['name']);
				$this->currentSimpleType = $attrs['name'];
				$this->simpleTypes[$attrs['name']] = $attrs;
				$this->simpleTypes[$attrs['name']]['typeClass'] = 'simpleType';
				$this->simpleTypes[$attrs['name']]['phpType'] = 'scalar';
			}
			else {
				$name = $this->CreateTypeName($this->currentComplexType . '_' . $this->currentElement);
				$this->xdebug('processing unnamed simpleType for element ' . $this->currentElement . ' named ' . $name);
				$this->currentSimpleType = $name;
				$this->simpleTypes[$this->currentSimpleType] = $attrs;
				$this->simpleTypes[$this->currentSimpleType]['phpType'] = 'scalar';
			}

			break;

		case 'union':
			$this->xdebug('do nothing for element ' . $name);
			break;

		default:
			$this->xdebug('do not have any logic to process element ' . $name);
			return NULL;
		}
	}

	/**
	* end-element handler
	*
	* @param    string $parser XML parser object
	* @param    string $name element name
	* @access   private
	*/
	public function schemaEndElement($parser, $name)
	{
		$this->depth--;

		if (isset($this->depth_array[$this->depth])) {
			$pos = $this->depth_array[$this->depth];
		}

		if ($prefix = $this->getPrefix($name)) {
			$name = $this->getLocalPart($name);
		}
		else {
			$prefix = '';
		}

		if ($name == 'complexType') {
			$this->xdebug('done processing complexType ' . ($this->currentComplexType ? $this->currentComplexType : '(unknown)'));
			$this->xdebug($this->varDump($this->complexTypes[$this->currentComplexType]));
			$this->currentComplexType = array_pop($this->complexTypeStack);
		}

		if ($name == 'element') {
			$this->xdebug('done processing element ' . ($this->currentElement ? $this->currentElement : '(unknown)'));
			$this->currentElement = array_pop($this->elementStack);
		}

		if ($name == 'simpleType') {
			$this->xdebug('done processing simpleType ' . ($this->currentSimpleType ? $this->currentSimpleType : '(unknown)'));
			$this->xdebug($this->varDump($this->simpleTypes[$this->currentSimpleType]));
			$this->currentSimpleType = array_pop($this->simpleTypeStack);
		}
	}

	/**
	* element content handler
	*
	* @param    string $parser XML parser object
	* @param    string $data element content
	* @access   private
	*/
	public function schemaCharacterData($parser, $data)
	{
		$pos = $this->depth_array[$this->depth - 1];
		$this->message[$pos]['cdata'] .= $data;
	}

	/**
	* serialize the schema
	*
	* @access   public
	*/
	public function serializeSchema()
	{
		$schemaPrefix = $this->getPrefixFromNamespace($this->XMLSchemaVersion);
		$xml = '';

		if (0 < sizeof($this->imports)) {
			foreach ($this->imports as $ns => $list) {
				foreach ($list as $ii) {
					if ($ii['location'] != '') {
						$xml .= ' <' . $schemaPrefix . ':import location="' . $ii['location'] . '" namespace="' . $ns . "\" />\n";
					}
					else {
						$xml .= ' <' . $schemaPrefix . ':import namespace="' . $ns . "\" />\n";
					}
				}
			}
		}

		foreach ($this->complexTypes as $typeName => $attrs) {
			$contentStr = '';
			if (isset($attrs['elements']) && 0 < count($attrs['elements'])) {
				foreach ($attrs['elements'] as $element => $eParts) {
					if (isset($eParts['ref'])) {
						$contentStr .= '   <' . $schemaPrefix . ':element ref="' . $element . "\"/>\n";
					}
					else {
						$contentStr .= '   <' . $schemaPrefix . ':element name="' . $element . '" type="' . $this->contractQName($eParts['type']) . '"';

						foreach ($eParts as $aName => $aValue) {
							if ($aName != 'name' && $aName != 'type') {
								$contentStr .= ' ' . $aName . '="' . $aValue . '"';
							}
						}

						$contentStr .= "/>\n";
					}
				}

				if (isset($attrs['compositor']) && $attrs['compositor'] != '') {
					$contentStr = '  <' . $schemaPrefix . ':' . $attrs['compositor'] . ">\n" . $contentStr . ('  </' . $schemaPrefix . ':' . $attrs['compositor'] . ">\n");
				}
			}

			if (isset($attrs['attrs']) && 1 <= count($attrs['attrs'])) {
				foreach ($attrs['attrs'] as $attr => $aParts) {
					$contentStr .= '    <' . $schemaPrefix . ':attribute';

					foreach ($aParts as $a => $v) {
						if ($a == 'ref' || $a == 'type') {
							$contentStr .= ' ' . $a . '="' . $this->contractQName($v) . '"';
						}
						else if ($a == 'http://schemas.xmlsoap.org/wsdl/:arrayType') {
							$this->usedNamespaces['wsdl'] = $this->namespaces['wsdl'];
							$contentStr .= ' wsdl:arrayType="' . $this->contractQName($v) . '"';
						}
						else {
							$contentStr .= ' ' . $a . '="' . $v . '"';
						}
					}

					$contentStr .= "/>\n";
				}
			}

			if (isset($attrs['restrictionBase']) && $attrs['restrictionBase'] != '') {
				$contentStr = '   <' . $schemaPrefix . ':restriction base="' . $this->contractQName($attrs['restrictionBase']) . "\">\n" . $contentStr . ('   </' . $schemaPrefix . ":restriction>\n");
				if (isset($attrs['elements']) && 0 < count($attrs['elements']) || isset($attrs['attrs']) && 0 < count($attrs['attrs'])) {
					$contentStr = '  <' . $schemaPrefix . ":complexContent>\n" . $contentStr . ('  </' . $schemaPrefix . ":complexContent>\n");
				}
			}

			if ($contentStr != '') {
				$contentStr = ' <' . $schemaPrefix . ':complexType name="' . $typeName . "\">\n" . $contentStr . (' </' . $schemaPrefix . ":complexType>\n");
			}
			else {
				$contentStr = ' <' . $schemaPrefix . ':complexType name="' . $typeName . "\"/>\n";
			}

			$xml .= $contentStr;
		}

		if (isset($this->simpleTypes) && 0 < count($this->simpleTypes)) {
			foreach ($this->simpleTypes as $typeName => $eParts) {
				$xml .= ' <' . $schemaPrefix . ':simpleType name="' . $typeName . "\">\n  <" . $schemaPrefix . ':restriction base="' . $this->contractQName($eParts['type']) . "\">\n";

				if (isset($eParts['enumeration'])) {
					foreach ($eParts['enumeration'] as $e) {
						$xml .= '  <' . $schemaPrefix . ':enumeration value="' . $e . "\"/>\n";
					}
				}

				$xml .= '  </' . $schemaPrefix . ":restriction>\n </" . $schemaPrefix . ':simpleType>';
			}
		}

		if (isset($this->elements) && 0 < count($this->elements)) {
			foreach ($this->elements as $element => $eParts) {
				$xml .= ' <' . $schemaPrefix . ':element name="' . $element . '" type="' . $this->contractQName($eParts['type']) . "\"/>\n";
			}
		}

		if (isset($this->attributes) && 0 < count($this->attributes)) {
			foreach ($this->attributes as $attr => $aParts) {
				$xml .= ' <' . $schemaPrefix . ':attribute name="' . $attr . '" type="' . $this->contractQName($aParts['type']) . "\"\n/>";
			}
		}

		$attr = '';

		foreach ($this->schemaInfo as $k => $v) {
			if ($k == 'elementFormDefault' || $k == 'attributeFormDefault') {
				$attr .= ' ' . $k . '="' . $v . '"';
			}
		}

		$el = '<' . $schemaPrefix . ':schema' . $attr . ' targetNamespace="' . $this->schemaTargetNamespace . "\"\n";

		foreach (array_diff($this->usedNamespaces, $this->enclosingNamespaces) as $nsp => $ns) {
			$el .= ' xmlns:' . $nsp . '="' . $ns . '"';
		}

		$xml = $el . ">\n" . $xml . ('</' . $schemaPrefix . ":schema>\n");
		return $xml;
	}

	/**
	* adds debug data to the clas level debug string
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function xdebug($string)
	{
		$this->debug('<' . $this->schemaTargetNamespace . '> ' . $string);
	}

	/**
    * get the PHP type of a user defined type in the schema
    * PHP type is kind of a misnomer since it actually returns 'struct' for assoc. arrays
    * returns false if no type exists, or not w/ the given namespace
    * else returns a string that is either a native php type, or 'struct'
    *
    * @param string $type name of defined type
    * @param string $ns namespace of type
    * @return mixed
    * @access public
    * @deprecated
    */
	public function getPHPType($type, $ns)
	{
		if (isset($this->typemap[$ns][$type])) {
			return $this->typemap[$ns][$type];
		}

		if (isset($this->complexTypes[$type])) {
			return $this->complexTypes[$type]['phpType'];
		}

		return false;
	}

	/**
    * returns an associative array of information about a given type
    * returns false if no type exists by the given name
    *
	*	For a complexType typeDef = array(
	*	'restrictionBase' => '',
	*	'phpType' => '',
	*	'compositor' => '(sequence|all)',
	*	'elements' => array(), // refs to elements array
	*	'attrs' => array() // refs to attributes array
	*	... and so on (see addComplexType)
	*	)
	*
	*   For simpleType or element, the array has different keys.
    *
    * @param string $type
    * @return mixed
    * @access public
    * @see addComplexType
    * @see addSimpleType
    * @see addElement
    */
	public function getTypeDef($type)
	{
		if (substr($type, -1) == '^') {
			$is_element = 1;
			$type = substr($type, 0, -1);
		}
		else {
			$is_element = 0;
		}

		if (!$is_element && isset($this->complexTypes[$type])) {
			$this->xdebug('in getTypeDef, found complexType ' . $type);
			return $this->complexTypes[$type];
		}

		if (!$is_element && isset($this->simpleTypes[$type])) {
			$this->xdebug('in getTypeDef, found simpleType ' . $type);

			if (!isset($this->simpleTypes[$type]['phpType'])) {
				$uqType = substr($this->simpleTypes[$type]['type'], strrpos($this->simpleTypes[$type]['type'], ':') + 1);
				$ns = substr($this->simpleTypes[$type]['type'], 0, strrpos($this->simpleTypes[$type]['type'], ':'));
				$etype = $this->getTypeDef($uqType);

				if ($etype) {
					$this->xdebug('in getTypeDef, found type for simpleType ' . $type . ':');
					$this->xdebug($this->varDump($etype));

					if (isset($etype['phpType'])) {
						$this->simpleTypes[$type]['phpType'] = $etype['phpType'];
					}

					if (isset($etype['elements'])) {
						$this->simpleTypes[$type]['elements'] = $etype['elements'];
					}
				}
			}

			return $this->simpleTypes[$type];
		}

		if (isset($this->elements[$type])) {
			$this->xdebug('in getTypeDef, found element ' . $type);

			if (!isset($this->elements[$type]['phpType'])) {
				$uqType = substr($this->elements[$type]['type'], strrpos($this->elements[$type]['type'], ':') + 1);
				$ns = substr($this->elements[$type]['type'], 0, strrpos($this->elements[$type]['type'], ':'));
				$etype = $this->getTypeDef($uqType);

				if ($etype) {
					$this->xdebug('in getTypeDef, found type for element ' . $type . ':');
					$this->xdebug($this->varDump($etype));

					if (isset($etype['phpType'])) {
						$this->elements[$type]['phpType'] = $etype['phpType'];
					}

					if (isset($etype['elements'])) {
						$this->elements[$type]['elements'] = $etype['elements'];
					}

					if (isset($etype['extensionBase'])) {
						$this->elements[$type]['extensionBase'] = $etype['extensionBase'];
					}
				}
				else {
					if ($ns == 'http://www.w3.org/2001/XMLSchema') {
						$this->xdebug('in getTypeDef, element ' . $type . ' is an XSD type');
						$this->elements[$type]['phpType'] = 'scalar';
					}
				}
			}

			return $this->elements[$type];
		}

		if (isset($this->attributes[$type])) {
			$this->xdebug('in getTypeDef, found attribute ' . $type);
			return $this->attributes[$type];
		}

		if (preg_match('/_ContainedType$/', $type)) {
			$this->xdebug('in getTypeDef, have an untyped element ' . $type);
			$typeDef['typeClass'] = 'simpleType';
			$typeDef['phpType'] = 'scalar';
			$typeDef['type'] = 'http://www.w3.org/2001/XMLSchema:string';
			return $typeDef;
		}

		$this->xdebug('in getTypeDef, did not find ' . $type);
		return false;
	}

	/**
    * returns a sample serialization of a given type, or false if no type by the given name
    *
    * @param string $type name of type
    * @return mixed
    * @access public
    * @deprecated
    */
	public function serializeTypeDef($type)
	{
		if ($typeDef = $this->getTypeDef($type)) {
			$str .= '<' . $type;

			if (is_array($typeDef['attrs'])) {
				foreach ($typeDef['attrs'] as $attName => $data) {
					$str .= ' ' . $attName . '="{type = ' . $data['type'] . '}"';
				}
			}

			$str .= ' xmlns="' . $this->schema['targetNamespace'] . '"';

			if (0 < count($typeDef['elements'])) {
				$str .= '>';

				foreach ($typeDef['elements'] as $element => $eData) {
					$str .= $this->serializeTypeDef($element);
				}

				$str .= '</' . $type . '>';
			}
			else if ($typeDef['typeClass'] == 'element') {
				$str .= '></' . $type . '>';
			}
			else {
				$str .= '/>';
			}

			return $str;
		}

		return false;
	}

	/**
    * returns HTML form elements that allow a user
    * to enter values for creating an instance of the given type.
    *
    * @param string $name name for type instance
    * @param string $type name of type
    * @return string
    * @access public
    * @deprecated
	*/
	public function typeToForm($name, $type)
	{
		if ($typeDef = $this->getTypeDef($type)) {
			if ($typeDef['phpType'] == 'struct') {
				$buffer .= '<table>';

				foreach ($typeDef['elements'] as $child => $childDef) {
					$buffer .= "\r\n\t\t\t\t\t<tr><td align='right'>" . $childDef['name'] . ' (type: ' . $this->getLocalPart($childDef['type']) . "):</td>\r\n\t\t\t\t\t<td><input type='text' name='parameters[" . $name . ('][' . $childDef['name'] . ']\'></td></tr>');
				}

				$buffer .= '</table>';
			}
			else if ($typeDef['phpType'] == 'array') {
				$buffer .= '<table>';
				$i = 0;

				while ($i < 3) {
					$buffer .= "\r\n\t\t\t\t\t<tr><td align='right'>array item (type: " . $typeDef['arrayType'] . "):</td>\r\n\t\t\t\t\t<td><input type='text' name='parameters[" . $name . '][]\'></td></tr>';
					++$i;
				}

				$buffer .= '</table>';
			}
			else {
				$buffer .= '<input type=\'text\' name=\'parameters[' . $name . ']\'>';
			}
		}
		else {
			$buffer .= '<input type=\'text\' name=\'parameters[' . $name . ']\'>';
		}

		return $buffer;
	}

	/**
	* adds a complex type to the schema
	* 
	* example: array
	* 
	* addType(
	* 	'ArrayOfstring',
	* 	'complexType',
	* 	'array',
	* 	'',
	* 	'SOAP-ENC:Array',
	* 	array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'string[]'),
	* 	'xsd:string'
	* );
	* 
	* example: PHP associative array ( SOAP Struct )
	* 
	* addType(
	* 	'SOAPStruct',
	* 	'complexType',
	* 	'struct',
	* 	'all',
	* 	array('myVar'=> array('name'=>'myVar','type'=>'string')
	* );
	* 
	* @param name
	* @param typeClass (complexType|simpleType|attribute)
	* @param phpType: currently supported are array and struct (php assoc array)
	* @param compositor (all|sequence|choice)
	* @param restrictionBase namespace:name (http://schemas.xmlsoap.org/soap/encoding/:Array)
	* @param elements = array ( name = array(name=>'',type=>'') )
	* @param attrs = array(
	* 	array(
	*		'ref' => "http://schemas.xmlsoap.org/soap/encoding/:arrayType",
	*		"http://schemas.xmlsoap.org/wsdl/:arrayType" => "string[]"
	* 	)
	* )
	* @param arrayType: namespace:name (http://www.w3.org/2001/XMLSchema:string)
	* @access public
	* @see getTypeDef
	*/
	public function addComplexType($name, $typeClass = 'complexType', $phpType = 'array', $compositor = '', $restrictionBase = '', $elements = array(), $attrs = array(), $arrayType = '')
	{
		$this->complexTypes[$name] = array('name' => $name, 'typeClass' => $typeClass, 'phpType' => $phpType, 'compositor' => $compositor, 'restrictionBase' => $restrictionBase, 'elements' => $elements, 'attrs' => $attrs, 'arrayType' => $arrayType);
		$this->xdebug('addComplexType ' . $name . ':');
		$this->appendDebug($this->varDump($this->complexTypes[$name]));
	}

	/**
	* adds a simple type to the schema
	*
	* @param string $name
	* @param string $restrictionBase namespace:name (http://schemas.xmlsoap.org/soap/encoding/:Array)
	* @param string $typeClass (should always be simpleType)
	* @param string $phpType (should always be scalar)
	* @param array $enumeration array of values
	* @access public
	* @see nusoap_xmlschema
	* @see getTypeDef
	*/
	public function addSimpleType($name, $restrictionBase = '', $typeClass = 'simpleType', $phpType = 'scalar', $enumeration = array())
	{
		$this->simpleTypes[$name] = array('name' => $name, 'typeClass' => $typeClass, 'phpType' => $phpType, 'type' => $restrictionBase, 'enumeration' => $enumeration);
		$this->xdebug('addSimpleType ' . $name . ':');
		$this->appendDebug($this->varDump($this->simpleTypes[$name]));
	}

	/**
	* adds an element to the schema
	*
	* @param array $attrs attributes that must include name and type
	* @see nusoap_xmlschema
	* @access public
	*/
	public function addElement($attrs)
	{
		if (!$this->getPrefix($attrs['type'])) {
			$attrs['type'] = $this->schemaTargetNamespace . ':' . $attrs['type'];
		}

		$this->elements[$attrs['name']] = $attrs;
		$this->elements[$attrs['name']]['typeClass'] = 'element';
		$this->xdebug('addElement ' . $attrs['name']);
		$this->appendDebug($this->varDump($this->elements[$attrs['name']]));
	}

	/**
	* constructor
	*
	* @access	public
	*/
	public function nusoap_base()
	{
		$this->debugLevel = $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* gets the global debug level, which applies to future instances
	*
	* @return	integer	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getGlobalDebugLevel()
	{
		return $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* sets the global debug level, which applies to future instances
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setGlobalDebugLevel($level)
	{
		$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = $level;
	}

	/**
	* gets the debug level for this instance
	*
	* @return	int	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}

	/**
	* sets the debug level for this instance
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}

	/**
	* adds debug data to the instance debug string with formatting
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function debug($string)
	{
		if (0 < $this->debugLevel) {
			$this->appendDebug($this->getmicrotime() . ' ' . get_class($this) . (': ' . $string . "\n"));
		}
	}

	/**
	* adds debug data to the instance debug string without formatting
	*
	* @param    string $string debug data
	* @access   public
	*/
	public function appendDebug($string)
	{
		if (0 < $this->debugLevel) {
			$this->debug_str .= $string;
		}
	}

	/**
	* clears the current debug data for this instance
	*
	* @access   public
	*/
	public function clearDebug()
	{
		$this->debug_str = '';
	}

	/**
	* gets the current debug data for this instance
	*
	* @return   debug data
	* @access   public
	*/
	public function& getDebug()
	{
		return $this->debug_str;
	}

	/**
	* gets the current debug data for this instance as an XML comment
	* this may change the contents of the debug data
	*
	* @return   debug data as an XML comment
	* @access   public
	*/
	public function& getDebugAsXMLComment()
	{
		while (strpos($this->debug_str, '--')) {
			$this->debug_str = str_replace('--', '- -', $this->debug_str);
		}

		$ret = "<!--\n" . $this->debug_str . "\n-->";
		return $ret;
	}

	/**
	* expands entities, e.g. changes '<' to '&lt;'.
	*
	* @param	string	$val	The string in which to expand entities.
	* @access	private
	*/
	public function expandEntities($val)
	{
		if ($this->charencoding) {
			$val = str_replace('&', '&amp;', $val);
			$val = str_replace('\'', '&apos;', $val);
			$val = str_replace('"', '&quot;', $val);
			$val = str_replace('<', '&lt;', $val);
			$val = str_replace('>', '&gt;', $val);
		}

		return $val;
	}

	/**
	* returns error string if present
	*
	* @return   mixed error string or false
	* @access   public
	*/
	public function getError()
	{
		if ($this->error_str != '') {
			return $this->error_str;
		}

		return false;
	}

	/**
	* sets error string
	*
	* @return   boolean $string error string
	* @access   private
	*/
	public function setError($str)
	{
		$this->error_str = $str;
	}

	/**
	* detect if array is a simple array or a struct (associative array)
	*
	* @param	mixed	$val	The PHP array
	* @return	string	(arraySimple|arrayStruct)
	* @access	private
	*/
	public function isArraySimpleOrStruct($val)
	{
		$keyList = array_keys($val);

		foreach ($keyList as $keyListValue) {
			if (!is_int($keyListValue)) {
				return 'arrayStruct';
			}
		}

		return 'arraySimple';
	}

	/**
	* serializes PHP values in accordance w/ section 5. Type information is
	* not serialized if $use == 'literal'.
	*
	* @param	mixed	$val	The value to serialize
	* @param	string	$name	The name (local part) of the XML element
	* @param	string	$type	The XML schema type (local part) for the element
	* @param	string	$name_ns	The namespace for the name of the XML element
	* @param	string	$type_ns	The namespace for the type of the element
	* @param	array	$attributes	The attributes to serialize as name=>value pairs
	* @param	string	$use	The WSDL "use" (encoded|literal)
	* @param	boolean	$soapval	Whether this is called from soapval.
	* @return	string	The serialized element, possibly with child elements
    * @access	public
	*/
	public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = 'encoded', $soapval = false)
	{
		$this->debug('in serialize_val: name=' . $name . ', type=' . $type . ', name_ns=' . $name_ns . ', type_ns=' . $type_ns . ', use=' . $use . ', soapval=' . $soapval);
		$this->appendDebug('value=' . $this->varDump($val));
		$this->appendDebug('attributes=' . $this->varDump($attributes));
		if (is_object($val) && get_class($val) == 'soapval' && !$soapval) {
			$this->debug('serialize_val: serialize soapval');
			$xml = $val->serialize($use);
			$this->appendDebug($val->getDebug());
			$val->clearDebug();
			$this->debug('serialize_val of soapval returning ' . $xml);
			return $xml;
		}

		if (is_numeric($name)) {
			$name = '__numeric_' . $name;
		}
		else {
			if (!$name) {
				$name = 'noname';
			}
		}

		$xmlns = '';

		if ($name_ns) {
			$prefix = 'nu' . rand(1000, 9999);
			$name = $prefix . ':' . $name;
			$xmlns .= ' xmlns:' . $prefix . '="' . $name_ns . '"';
		}

		if ($type_ns != '' && $type_ns == $this->namespaces['xsd']) {
			$type_prefix = 'xsd';
		}
		else {
			if ($type_ns) {
				$type_prefix = 'ns' . rand(1000, 9999);
				$xmlns .= ' xmlns:' . $type_prefix . '="' . $type_ns . '"';
			}
		}

		$atts = '';

		if ($attributes) {
			foreach ($attributes as $k => $v) {
				$atts .= ' ' . $k . '="' . $this->expandEntities($v) . '"';
			}
		}

		if (is_null($val)) {
			$this->debug('serialize_val: serialize null');

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '/>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			$xml = '<' . $name . $xmlns . $type_str . $atts . ' xsi:nil="true"/>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		if ($type != '' && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
			$this->debug('serialize_val: serialize xsd built-in primitive type');

			if (is_bool($val)) {
				if ($type == 'boolean') {
					$val = $val ? 'true' : 'false';
				}
				else {
					if (!$val) {
						$val = 0;
					}
				}
			}
			else {
				if (is_string($val)) {
					$val = $this->expandEntities($val);
				}
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			$xml = '<' . $name . $xmlns . ' xsi:type="xsd:' . $type . '"' . $atts . '>' . $val . '</' . $name . '>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		$xml = '';
		switch (true) {
		case is_bool($val) || $type == 'boolean':
			$this->debug('serialize_val: serialize boolean');

			if ($type == 'boolean') {
				$val = $val ? 'true' : 'false';
			}
			else {
				if (!$val) {
					$val = 0;
				}
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:boolean"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_int($val) || is_long($val) || $type == 'int':
			$this->debug('serialize_val: serialize int');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:int"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_float($val) || is_double($val) || $type == 'float':
			$this->debug('serialize_val: serialize float');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:float"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_string($val) || $type == 'string':
			$this->debug('serialize_val: serialize string');
			$val = $this->expandEntities($val);

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:string"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_object($val):
			$this->debug('serialize_val: serialize object');

			if (get_class($val) == 'soapval') {
				$this->debug('serialize_val: serialize soapval object');
				$pXml = $val->serialize($use);
				$this->appendDebug($val->getDebug());
				$val->clearDebug();
			}
			else {
				if (!$name) {
					$name = get_class($val);
					$this->debug('In serialize_val, used class name ' . $name . ' as element name');
				}
				else {
					$this->debug('In serialize_val, do not override name ' . $name . ' for element name for class ' . get_class($val));
				}

				foreach (get_object_vars($val) as $k => $v) {
					$pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $pXml . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . $type_str . $atts . '>' . $pXml . '</' . $name . '>';
			}

			break;

		case is_array($val) || $type:
			$valueType = $this->isArraySimpleOrStruct($val);
			if ($valueType == 'arraySimple' || preg_match('/^ArrayOf/', $type)) {
				$this->debug('serialize_val: serialize array');
				$i = 0;
				if (is_array($val) && 0 < count($val)) {
					foreach ($val as $v) {
						if (is_object($v) && get_class($v) == 'soapval') {
							$tt_ns = $v->type_ns;
							$tt = $v->type;
						}
						else if (is_array($v)) {
							$tt = $this->isArraySimpleOrStruct($v);
						}
						else {
							$tt = gettype($v);
						}

						$array_types[$tt] = 1;
						$xml .= $this->serialize_val($v, 'item', false, false, false, false, $use);
						++$i;
					}

					if (1 < count($array_types)) {
						$array_typename = 'xsd:anyType';
					}
					else {
						if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
							if ($tt == 'integer') {
								$tt = 'int';
							}

							$array_typename = 'xsd:' . $tt;
						}
						else {
							if (isset($tt) && $tt == 'arraySimple') {
								$array_typename = 'SOAP-ENC:Array';
							}
							else {
								if (isset($tt) && $tt == 'arrayStruct') {
									$array_typename = 'unnamed_struct_use_soapval';
								}
								else {
									if ($tt_ns != '' && $tt_ns == $this->namespaces['xsd']) {
										$array_typename = 'xsd:' . $tt;
									}
									else if ($tt_ns) {
										$tt_prefix = 'ns' . rand(1000, 9999);
										$array_typename = $tt_prefix . ':' . $tt;
										$xmlns .= ' xmlns:' . $tt_prefix . '="' . $tt_ns . '"';
									}
									else {
										$array_typename = $tt;
									}
								}
							}
						}
					}

					$array_type = $i;

					if ($use == 'literal') {
						$type_str = '';
					}
					else {
						if (isset($type) && isset($type_prefix)) {
							$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
						}
						else {
							$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="' . $array_typename . ('[' . $array_type . ']"');
						}
					}
				}
				else if ($use == 'literal') {
					$type_str = '';
				}
				else {
					if (isset($type) && isset($type_prefix)) {
						$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
					}
					else {
						$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="xsd:anyType[0]"';
					}
				}

				$xml = '<' . $name . $xmlns . $type_str . $atts . '>' . $xml . ('</' . $name . '>');
			}
			else {
				$this->debug('serialize_val: serialize struct');
				if (isset($type) && isset($type_prefix)) {
					$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
				}
				else {
					$type_str = '';
				}

				if ($use == 'literal') {
					$xml .= '<' . $name . $xmlns . $atts . '>';
				}
				else {
					$xml .= '<' . $name . $xmlns . $type_str . $atts . '>';
				}

				foreach ($val as $k => $v) {
					if ($type == 'Map' && $type_ns == 'http://xml.apache.org/xml-soap') {
						$xml .= '<item>';
						$xml .= $this->serialize_val($k, 'key', false, false, false, false, $use);
						$xml .= $this->serialize_val($v, 'value', false, false, false, false, $use);
						$xml .= '</item>';
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$xml .= '</' . $name . '>';
			}

			break;

		default:
			$this->debug('serialize_val: serialize unknown');
			$xml .= 'not detected, got ' . gettype($val) . ' for ' . $val;
			break;
		}

		$this->debug('serialize_val returning ' . $xml);
		return $xml;
	}

	/**
    * serializes a message
    *
    * @param string $body the XML of the SOAP body
    * @param mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
    * @param array $namespaces optional the namespaces used in generating the body and headers
    * @param string $style optional (rpc|document)
    * @param string $use optional (encoded|literal)
    * @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
    * @return string the message
    * @access public
    */
	public function serializeEnvelope($body, $headers = false, $namespaces = array(), $style = 'rpc', $use = 'encoded', $encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/')
	{
		$this->debug('In serializeEnvelope length=' . strlen($body) . ' body (max 1000 characters)=' . substr($body, 0, 1000) . (' style=' . $style . ' use=' . $use . ' encodingStyle=' . $encodingStyle));
		$this->debug('headers:');
		$this->appendDebug($this->varDump($headers));
		$this->debug('namespaces:');
		$this->appendDebug($this->varDump($namespaces));
		$ns_string = '';

		foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
			$ns_string .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if ($encodingStyle) {
			$ns_string = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"' . $ns_string;
		}

		if ($headers) {
			if (is_array($headers)) {
				$xml = '';

				foreach ($headers as $k => $v) {
					if (is_object($v) && get_class($v) == 'soapval') {
						$xml .= $this->serialize_val($v, false, false, false, false, false, $use);
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$headers = $xml;
				$this->debug('In serializeEnvelope, serialized array of headers to ' . $headers);
			}

			$headers = '<SOAP-ENV:Header>' . $headers . '</SOAP-ENV:Header>';
		}

		return '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?' . '>' . '<SOAP-ENV:Envelope' . $ns_string . '>' . $headers . '<SOAP-ENV:Body>' . $body . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
	}

	/**
	 * formats a string to be inserted into an HTML stream
	 *
	 * @param string $str The string to format
	 * @return string The formatted string
	 * @access public
	 * @deprecated
	 */
	public function formatDump($str)
	{
		$str = htmlspecialchars($str);
		return nl2br($str);
	}

	/**
	* contracts (changes namespace to prefix) a qualified name
	*
	* @param    string $qname qname
	* @return	string contracted qname
	* @access   private
	*/
	public function contractQname($qname)
	{
		if (strrpos($qname, ':')) {
			$name = substr($qname, strrpos($qname, ':') + 1);
			$ns = substr($qname, 0, strrpos($qname, ':'));
			$p = $this->getPrefixFromNamespace($ns);

			if ($p) {
				return $p . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
	* expands (changes prefix to namespace) a qualified name
	*
	* @param    string $qname qname
	* @return	string expanded qname
	* @access   private
	*/
	public function expandQname($qname)
	{
		if (strpos($qname, ':') && !preg_match('/^http:\\/\\//', $qname)) {
			$name = substr(strstr($qname, ':'), 1);
			$prefix = substr($qname, 0, strpos($qname, ':'));

			if (isset($this->namespaces[$prefix])) {
				return $this->namespaces[$prefix] . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
    * returns the local part of a prefixed string
    * returns the original string, if not prefixed
    *
    * @param string $str The prefixed string
    * @return string The local part
    * @access public
    */
	public function getLocalPart($str)
	{
		if ($sstr = strrchr($str, ':')) {
			return substr($sstr, 1);
		}

		return $str;
	}

	/**
    * returns the prefix part of a prefixed string
    * returns false, if not prefixed
    *
    * @param string $str The prefixed string
    * @return mixed The prefix or false if there is no prefix
    * @access public
    */
	public function getPrefix($str)
	{
		if ($pos = strrpos($str, ':')) {
			return substr($str, 0, $pos);
		}

		return false;
	}

	/**
    * pass it a prefix, it returns a namespace
    *
    * @param string $prefix The prefix
    * @return mixed The namespace, false if no namespace has the specified prefix
    * @access public
    */
	public function getNamespaceFromPrefix($prefix)
	{
		if (isset($this->namespaces[$prefix])) {
			return $this->namespaces[$prefix];
		}

		return false;
	}

	/**
    * returns the prefix for a given namespace (or prefix)
    * or false if no prefixes registered for the given namespace
    *
    * @param string $ns The namespace
    * @return mixed The prefix, false if the namespace has no prefixes
    * @access public
    */
	public function getPrefixFromNamespace($ns)
	{
		foreach ($this->namespaces as $p => $n) {
			if ($ns == $n || $ns == $p) {
				$this->usedNamespaces[$p] = $n;
				return $p;
			}
		}

		return false;
	}

	/**
    * returns the time in ODBC canonical form with microseconds
    *
    * @return string The time in ODBC canonical form with microseconds
    * @access public
    */
	public function getmicrotime()
	{
		if (function_exists('gettimeofday')) {
			$tod = gettimeofday();
			$sec = $tod['sec'];
			$usec = $tod['usec'];
		}
		else {
			$sec = time();
			$usec = 0;
		}

		return strftime('%Y-%m-%d %H:%M:%S', $sec) . '.' . sprintf('%06d', $usec);
	}

	/**
	 * Returns a string with the output of var_dump
	 *
	 * @param mixed $data The variable to var_dump
	 * @return string The output of var_dump
	 * @access public
	 */
	public function varDump($data)
	{
		ob_start();
		var_dump($data);
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	/**
	* represents the object as a string
	*
	* @return	string
	* @access   public
	*/
	public function __toString()
	{
		return $this->varDump($this);
	}
}

class XMLSchema extends nusoap_xmlschema
{
	public $schema = '';
	public $xml = '';
	public $enclosingNamespaces;
	public $schemaInfo = array();
	public $schemaTargetNamespace = '';
	public $attributes = array();
	public $complexTypes = array();
	public $complexTypeStack = array();
	public $currentComplexType;
	public $elements = array();
	public $elementStack = array();
	public $currentElement;
	public $simpleTypes = array();
	public $simpleTypeStack = array();
	public $currentSimpleType;
	public $imports = array();
	public $parser;
	public $position = 0;
	public $depth = 0;
	public $depth_array = array();
	public $message = array();
	public $defaultNamespace = array();
	/**
	 * Identification for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $title = 'NuSOAP';
	/**
	 * Version for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $version = '0.9.5';
	/**
	 * CVS revision for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $revision = '$Revision: 1.123 $';
	/**
     * Current error string (manipulated by getError/setError)
	 *
	 * @var string
	 * @access private
	 */
	public $error_str = '';
	/**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
	 *
	 * @var string
	 * @access private
	 */
	public $debug_str = '';
	/**
	 * toggles automatic encoding of special characters as entities
	 * (should always be true, I think)
	 *
	 * @var boolean
	 * @access private
	 */
	public $charencoding = true;
	/**
	 * the debug level for this instance
	 *
	 * @var	integer
	 * @access private
	 */
	public $debugLevel;
	/**
	* set schema version
	*
	* @var      string
	* @access   public
	*/
	public $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';
	/**
	* charset encoding for outgoing messages
	*
	* @var      string
	* @access   public
	*/
	public $soap_defencoding = 'ISO-8859-1';
	/**
	* namespaces in an array of prefix => uri
	*
	* this is "seeded" by a set of constants, but it may be altered by code
	*
	* @var      array
	* @access   public
	*/
	public $namespaces = array('SOAP-ENV' => 'http://schemas.xmlsoap.org/soap/envelope/', 'xsd' => 'http://www.w3.org/2001/XMLSchema', 'xsi' => 'http://www.w3.org/2001/XMLSchema-instance', 'SOAP-ENC' => 'http://schemas.xmlsoap.org/soap/encoding/');
	/**
	* namespaces used in the current context, e.g. during serialization
	*
	* @var      array
	* @access   private
	*/
	public $usedNamespaces = array();
	/**
	* XML Schema types in an array of uri => (array of xml type => php type)
	* is this legacy yet?
	* no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
	* @var      array
	* @access   public
	*/
	public $typemap = array(
		'http://www.w3.org/2001/XMLSchema'          => array('string' => 'string', 'boolean' => 'boolean', 'float' => 'double', 'double' => 'double', 'decimal' => 'double', 'duration' => '', 'dateTime' => 'string', 'time' => 'string', 'date' => 'string', 'gYearMonth' => '', 'gYear' => '', 'gMonthDay' => '', 'gDay' => '', 'gMonth' => '', 'hexBinary' => 'string', 'base64Binary' => 'string', 'anyType' => 'string', 'anySimpleType' => 'string', 'normalizedString' => 'string', 'token' => 'string', 'language' => '', 'NMTOKEN' => '', 'NMTOKENS' => '', 'Name' => '', 'NCName' => '', 'ID' => '', 'IDREF' => '', 'IDREFS' => '', 'ENTITY' => '', 'ENTITIES' => '', 'integer' => 'integer', 'nonPositiveInteger' => 'integer', 'negativeInteger' => 'integer', 'long' => 'integer', 'int' => 'integer', 'short' => 'integer', 'byte' => 'integer', 'nonNegativeInteger' => 'integer', 'unsignedLong' => '', 'unsignedInt' => '', 'unsignedShort' => '', 'unsignedByte' => '', 'positiveInteger' => ''),
		'http://www.w3.org/2000/10/XMLSchema'       => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://www.w3.org/1999/XMLSchema'          => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://soapinterop.org/xsd'                => array('SOAPStruct' => 'struct'),
		'http://schemas.xmlsoap.org/soap/encoding/' => array('base64' => 'string', 'array' => 'array', 'Array' => 'array'),
		'http://xml.apache.org/xml-soap'            => array('Map')
		);
	/**
	* XML entities to convert
	*
	* @var      array
	* @access   public
	* @deprecated
	* @see	expandEntities
	*/
	public $xmlEntities = array('quot' => '"', 'amp' => '&', 'lt' => '<', 'gt' => '>', 'apos' => '\'');

	/**
	* constructor
	*
	* @param    string $schema schema document URI
	* @param    string $xml xml document URI
	* @param	string $namespaces namespaces defined in enclosing XML
	* @access   public
	*/
	public function nusoap_xmlschema($schema = '', $xml = '', $namespaces = array())
	{
		parent::nusoap_base();
		$this->debug('nusoap_xmlschema class instantiated, inside constructor');
		$this->schema = $schema;
		$this->xml = $xml;
		$this->enclosingNamespaces = $namespaces;
		$this->namespaces = array_merge($this->namespaces, $namespaces);

		if ($schema != '') {
			$this->debug('initial schema file: ' . $schema);
			$this->parseFile($schema, 'schema');
		}

		if ($xml != '') {
			$this->debug('initial xml file: ' . $xml);
			$this->parseFile($xml, 'xml');
		}
	}

	/**
    * parse an XML file
    *
    * @param string $xml path/URL to XML file
    * @param string $type (schema | xml)
	* @return boolean
    * @access public
    */
	public function parseFile($xml, $type)
	{
		if ($xml != '') {
			$xmlStr = @join('', @file($xml));

			if ($xmlStr == '') {
				$msg = 'Error reading XML from ' . $xml;
				$this->setError($msg);
				$this->debug($msg);
				return false;
			}

			$this->debug('parsing ' . $xml);
			$this->parseString($xmlStr, $type);
			$this->debug('done parsing ' . $xml);
			return true;
		}

		return false;
	}

	/**
	* parse an XML string
	*
	* @param    string $xml path or URL
    * @param	string $type (schema|xml)
	* @access   private
	*/
	public function parseString($xml, $type)
	{
		if ($xml != '') {
			$this->parser = xml_parser_create();
			xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);
			xml_set_object($this->parser, $this);

			if ($type == 'schema') {
				xml_set_element_handler($this->parser, 'schemaStartElement', 'schemaEndElement');
				xml_set_character_data_handler($this->parser, 'schemaCharacterData');
			}
			else {
				if ($type == 'xml') {
					xml_set_element_handler($this->parser, 'xmlStartElement', 'xmlEndElement');
					xml_set_character_data_handler($this->parser, 'xmlCharacterData');
				}
			}

			if (!xml_parse($this->parser, $xml, true)) {
				$errstr = sprintf('XML error parsing XML schema on line %d: %s', xml_get_current_line_number($this->parser), xml_error_string(xml_get_error_code($this->parser)));
				$this->debug($errstr);
				$this->debug("XML payload:\n" . $xml);
				$this->setError($errstr);
			}

			xml_parser_free($this->parser);
			return NULL;
		}

		$this->debug('no xml passed to parseString()!!');
		$this->setError('no xml passed to parseString()!!');
	}

	/**
	 * gets a type name for an unnamed type
	 *
	 * @param	string	Element name
	 * @return	string	A type name for an unnamed type
	 * @access	private
	 */
	public function CreateTypeName($ename)
	{
		$scope = '';
		$i = 0;

		while ($i < count($this->complexTypeStack)) {
			$scope .= $this->complexTypeStack[$i] . '_';
			++$i;
		}

		return $scope . $ename . '_ContainedType';
	}

	/**
	* start-element handler
	*
	* @param    string $parser XML parser object
	* @param    string $name element name
	* @param    string $attrs associative array of attributes
	* @access   private
	*/
	public function schemaStartElement($parser, $name, $attrs)
	{
		$pos = $this->position++;
		$depth = $this->depth++;
		$this->depth_array[$depth] = $pos;
		$this->message[$pos] = array('cdata' => '');

		if (0 < $depth) {
			$this->defaultNamespace[$pos] = $this->defaultNamespace[$this->depth_array[$depth - 1]];
		}
		else {
			$this->defaultNamespace[$pos] = false;
		}

		if ($prefix = $this->getPrefix($name)) {
			$name = $this->getLocalPart($name);
		}
		else {
			$prefix = '';
		}

		if (0 < count($attrs)) {
			foreach ($attrs as $k => $v) {
				if (preg_match('/^xmlns/', $k)) {
					if ($ns_prefix = substr(strrchr($k, ':'), 1)) {
						$this->namespaces[$ns_prefix] = $v;
					}
					else {
						$this->defaultNamespace[$pos] = $v;

						if (!$this->getPrefixFromNamespace($v)) {
							$this->namespaces['ns' . (count($this->namespaces) + 1)] = $v;
						}
					}

					if ($v == 'http://www.w3.org/2001/XMLSchema' || $v == 'http://www.w3.org/1999/XMLSchema' || $v == 'http://www.w3.org/2000/10/XMLSchema') {
						$this->XMLSchemaVersion = $v;
						$this->namespaces['xsi'] = $v . '-instance';
					}
				}
			}

			foreach ($attrs as $k => $v) {
				$k = strpos($k, ':') ? $this->expandQname($k) : $k;
				$v = strpos($v, ':') ? $this->expandQname($v) : $v;
				$eAttrs[$k] = $v;
			}

			$attrs = $eAttrs;
		}
		else {
			$attrs = array();
		}

		switch ($name) {
		case 'all':
		case 'choice':
		case 'group':
		case 'sequence':
			$this->complexTypes[$this->currentComplexType]['compositor'] = $name;
			break;

		case 'attribute':
			$this->xdebug('parsing attribute:');
			$this->appendDebug($this->varDump($attrs));

			if (!isset($attrs['form'])) {
				$attrs['form'] = $this->schemaInfo['attributeFormDefault'];
			}

			if (isset($attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'])) {
				$v = $attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'];

				if (!strpos($v, ':')) {
					if ($this->defaultNamespace[$pos]) {
						$attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'] = $this->defaultNamespace[$pos] . ':' . $attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'];
					}
				}
			}

			if (isset($attrs['name'])) {
				$this->attributes[$attrs['name']] = $attrs;
				$aname = $attrs['name'];
			}
			else {
				if (isset($attrs['ref']) && $attrs['ref'] == 'http://schemas.xmlsoap.org/soap/encoding/:arrayType') {
					if (isset($attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'])) {
						$aname = $attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'];
					}
					else {
						$aname = '';
					}
				}
				else {
					if (isset($attrs['ref'])) {
						$aname = $attrs['ref'];
						$this->attributes[$attrs['ref']] = $attrs;
					}
				}
			}

			if ($this->currentComplexType) {
				$this->complexTypes[$this->currentComplexType]['attrs'][$aname] = $attrs;
			}

			if (isset($attrs['http://schemas.xmlsoap.org/wsdl/:arrayType']) || $this->getLocalPart($aname) == 'arrayType') {
				$this->complexTypes[$this->currentComplexType]['phpType'] = 'array';
				$prefix = $this->getPrefix($aname);

				if (isset($attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'])) {
					$v = $attrs['http://schemas.xmlsoap.org/wsdl/:arrayType'];
				}
				else {
					$v = '';
				}

				if (strpos($v, '[,]')) {
					$this->complexTypes[$this->currentComplexType]['multidimensional'] = true;
				}

				$v = substr($v, 0, strpos($v, '['));
				if (!strpos($v, ':') && isset($this->typemap[$this->XMLSchemaVersion][$v])) {
					$v = $this->XMLSchemaVersion . ':' . $v;
				}

				$this->complexTypes[$this->currentComplexType]['arrayType'] = $v;
			}

			break;

		case 'complexContent':
			$this->xdebug('do nothing for element ' . $name);
			break;

		case 'complexType':
			array_push($this->complexTypeStack, $this->currentComplexType);

			if (isset($attrs['name'])) {
				$this->xdebug('processing named complexType ' . $attrs['name']);
				$this->currentComplexType = $attrs['name'];
				$this->complexTypes[$this->currentComplexType] = $attrs;
				$this->complexTypes[$this->currentComplexType]['typeClass'] = 'complexType';
				if (isset($attrs['base']) && preg_match('/:Array$/', $attrs['base'])) {
					$this->xdebug('complexType is unusual array');
					$this->complexTypes[$this->currentComplexType]['phpType'] = 'array';
				}
				else {
					$this->complexTypes[$this->currentComplexType]['phpType'] = 'struct';
				}
			}
			else {
				$name = $this->CreateTypeName($this->currentElement);
				$this->xdebug('processing unnamed complexType for element ' . $this->currentElement . ' named ' . $name);
				$this->currentComplexType = $name;
				$this->complexTypes[$this->currentComplexType] = $attrs;
				$this->complexTypes[$this->currentComplexType]['typeClass'] = 'complexType';
				if (isset($attrs['base']) && preg_match('/:Array$/', $attrs['base'])) {
					$this->xdebug('complexType is unusual array');
					$this->complexTypes[$this->currentComplexType]['phpType'] = 'array';
				}
				else {
					$this->complexTypes[$this->currentComplexType]['phpType'] = 'struct';
				}
			}

			$this->complexTypes[$this->currentComplexType]['simpleContent'] = 'false';
			break;

		case 'element':
			array_push($this->elementStack, $this->currentElement);

			if (!isset($attrs['form'])) {
				if ($this->currentComplexType) {
					$attrs['form'] = $this->schemaInfo['elementFormDefault'];
				}
				else {
					$attrs['form'] = 'qualified';
				}
			}

			if (isset($attrs['type'])) {
				$this->xdebug('processing typed element ' . $attrs['name'] . ' of type ' . $attrs['type']);

				if (!$this->getPrefix($attrs['type'])) {
					if ($this->defaultNamespace[$pos]) {
						$attrs['type'] = $this->defaultNamespace[$pos] . ':' . $attrs['type'];
						$this->xdebug('used default namespace to make type ' . $attrs['type']);
					}
				}

				if ($this->currentComplexType && $this->complexTypes[$this->currentComplexType]['phpType'] == 'array') {
					$this->xdebug('arrayType for unusual array is ' . $attrs['type']);
					$this->complexTypes[$this->currentComplexType]['arrayType'] = $attrs['type'];
				}

				$this->currentElement = $attrs['name'];
				$ename = $attrs['name'];
			}
			else if (isset($attrs['ref'])) {
				$this->xdebug('processing element as ref to ' . $attrs['ref']);
				$this->currentElement = 'ref to ' . $attrs['ref'];
				$ename = $this->getLocalPart($attrs['ref']);
			}
			else {
				$type = $this->CreateTypeName($this->currentComplexType . '_' . $attrs['name']);
				$this->xdebug('processing untyped element ' . $attrs['name'] . ' type ' . $type);
				$this->currentElement = $attrs['name'];
				$attrs['type'] = $this->schemaTargetNamespace . ':' . $type;
				$ename = $attrs['name'];
			}

			if (isset($ename) && $this->currentComplexType) {
				$this->xdebug('add element ' . $ename . ' to complexType ' . $this->currentComplexType);
				$this->complexTypes[$this->currentComplexType]['elements'][$ename] = $attrs;
			}
			else {
				if (!isset($attrs['ref'])) {
					$this->xdebug('add element ' . $ename . ' to elements array');
					$this->elements[$attrs['name']] = $attrs;
					$this->elements[$attrs['name']]['typeClass'] = 'element';
				}
			}

			break;

		case 'enumeration':
			$this->xdebug('enumeration ' . $attrs['value']);

			if ($this->currentSimpleType) {
				$this->simpleTypes[$this->currentSimpleType]['enumeration'][] = $attrs['value'];
			}
			else {
				if ($this->currentComplexType) {
					$this->complexTypes[$this->currentComplexType]['enumeration'][] = $attrs['value'];
				}
			}

			break;

		case 'extension':
			$this->xdebug('extension ' . $attrs['base']);

			if ($this->currentComplexType) {
				$ns = $this->getPrefix($attrs['base']);

				if ($ns == '') {
					$this->complexTypes[$this->currentComplexType]['extensionBase'] = $this->schemaTargetNamespace . ':' . $attrs['base'];
				}
				else {
					$this->complexTypes[$this->currentComplexType]['extensionBase'] = $attrs['base'];
				}
			}
			else {
				$this->xdebug('no current complexType to set extensionBase');
			}

			break;

		case 'import':
			if (isset($attrs['schemaLocation'])) {
				$this->xdebug('import namespace ' . $attrs['namespace'] . ' from ' . $attrs['schemaLocation']);
				$this->imports[$attrs['namespace']][] = array('location' => $attrs['schemaLocation'], 'loaded' => false);
			}
			else {
				$this->xdebug('import namespace ' . $attrs['namespace']);
				$this->imports[$attrs['namespace']][] = array('location' => '', 'loaded' => true);

				if (!$this->getPrefixFromNamespace($attrs['namespace'])) {
					$this->namespaces['ns' . (count($this->namespaces) + 1)] = $attrs['namespace'];
				}
			}

			break;

		case 'include':
			if (isset($attrs['schemaLocation'])) {
				$this->xdebug('include into namespace ' . $this->schemaTargetNamespace . ' from ' . $attrs['schemaLocation']);
				$this->imports[$this->schemaTargetNamespace][] = array('location' => $attrs['schemaLocation'], 'loaded' => false);
			}
			else {
				$this->xdebug('ignoring invalid XML Schema construct: include without schemaLocation attribute');
			}

			break;

		case 'list':
			$this->xdebug('do nothing for element ' . $name);
			break;

		case 'restriction':
			$this->xdebug('restriction ' . $attrs['base']);

			if ($this->currentSimpleType) {
				$this->simpleTypes[$this->currentSimpleType]['type'] = $attrs['base'];
			}
			else {
				if ($this->currentComplexType) {
					$this->complexTypes[$this->currentComplexType]['restrictionBase'] = $attrs['base'];

					if (strstr($attrs['base'], ':') == ':Array') {
						$this->complexTypes[$this->currentComplexType]['phpType'] = 'array';
					}
				}
			}

			break;

		case 'schema':
			$this->schemaInfo = $attrs;
			$this->schemaInfo['schemaVersion'] = $this->getNamespaceFromPrefix($prefix);

			if (isset($attrs['targetNamespace'])) {
				$this->schemaTargetNamespace = $attrs['targetNamespace'];
			}

			if (!isset($attrs['elementFormDefault'])) {
				$this->schemaInfo['elementFormDefault'] = 'unqualified';
			}

			if (!isset($attrs['attributeFormDefault'])) {
				$this->schemaInfo['attributeFormDefault'] = 'unqualified';
			}

			break;

		case 'simpleContent':
			if ($this->currentComplexType) {
				$this->complexTypes[$this->currentComplexType]['simpleContent'] = 'true';
			}
			else {
				$this->xdebug('do nothing for element ' . $name . ' because there is no current complexType');
			}

			break;

		case 'simpleType':
			array_push($this->simpleTypeStack, $this->currentSimpleType);

			if (isset($attrs['name'])) {
				$this->xdebug('processing simpleType for name ' . $attrs['name']);
				$this->currentSimpleType = $attrs['name'];
				$this->simpleTypes[$attrs['name']] = $attrs;
				$this->simpleTypes[$attrs['name']]['typeClass'] = 'simpleType';
				$this->simpleTypes[$attrs['name']]['phpType'] = 'scalar';
			}
			else {
				$name = $this->CreateTypeName($this->currentComplexType . '_' . $this->currentElement);
				$this->xdebug('processing unnamed simpleType for element ' . $this->currentElement . ' named ' . $name);
				$this->currentSimpleType = $name;
				$this->simpleTypes[$this->currentSimpleType] = $attrs;
				$this->simpleTypes[$this->currentSimpleType]['phpType'] = 'scalar';
			}

			break;

		case 'union':
			$this->xdebug('do nothing for element ' . $name);
			break;

		default:
			$this->xdebug('do not have any logic to process element ' . $name);
			return NULL;
		}
	}

	/**
	* end-element handler
	*
	* @param    string $parser XML parser object
	* @param    string $name element name
	* @access   private
	*/
	public function schemaEndElement($parser, $name)
	{
		$this->depth--;

		if (isset($this->depth_array[$this->depth])) {
			$pos = $this->depth_array[$this->depth];
		}

		if ($prefix = $this->getPrefix($name)) {
			$name = $this->getLocalPart($name);
		}
		else {
			$prefix = '';
		}

		if ($name == 'complexType') {
			$this->xdebug('done processing complexType ' . ($this->currentComplexType ? $this->currentComplexType : '(unknown)'));
			$this->xdebug($this->varDump($this->complexTypes[$this->currentComplexType]));
			$this->currentComplexType = array_pop($this->complexTypeStack);
		}

		if ($name == 'element') {
			$this->xdebug('done processing element ' . ($this->currentElement ? $this->currentElement : '(unknown)'));
			$this->currentElement = array_pop($this->elementStack);
		}

		if ($name == 'simpleType') {
			$this->xdebug('done processing simpleType ' . ($this->currentSimpleType ? $this->currentSimpleType : '(unknown)'));
			$this->xdebug($this->varDump($this->simpleTypes[$this->currentSimpleType]));
			$this->currentSimpleType = array_pop($this->simpleTypeStack);
		}
	}

	/**
	* element content handler
	*
	* @param    string $parser XML parser object
	* @param    string $data element content
	* @access   private
	*/
	public function schemaCharacterData($parser, $data)
	{
		$pos = $this->depth_array[$this->depth - 1];
		$this->message[$pos]['cdata'] .= $data;
	}

	/**
	* serialize the schema
	*
	* @access   public
	*/
	public function serializeSchema()
	{
		$schemaPrefix = $this->getPrefixFromNamespace($this->XMLSchemaVersion);
		$xml = '';

		if (0 < sizeof($this->imports)) {
			foreach ($this->imports as $ns => $list) {
				foreach ($list as $ii) {
					if ($ii['location'] != '') {
						$xml .= ' <' . $schemaPrefix . ':import location="' . $ii['location'] . '" namespace="' . $ns . "\" />\n";
					}
					else {
						$xml .= ' <' . $schemaPrefix . ':import namespace="' . $ns . "\" />\n";
					}
				}
			}
		}

		foreach ($this->complexTypes as $typeName => $attrs) {
			$contentStr = '';
			if (isset($attrs['elements']) && 0 < count($attrs['elements'])) {
				foreach ($attrs['elements'] as $element => $eParts) {
					if (isset($eParts['ref'])) {
						$contentStr .= '   <' . $schemaPrefix . ':element ref="' . $element . "\"/>\n";
					}
					else {
						$contentStr .= '   <' . $schemaPrefix . ':element name="' . $element . '" type="' . $this->contractQName($eParts['type']) . '"';

						foreach ($eParts as $aName => $aValue) {
							if ($aName != 'name' && $aName != 'type') {
								$contentStr .= ' ' . $aName . '="' . $aValue . '"';
							}
						}

						$contentStr .= "/>\n";
					}
				}

				if (isset($attrs['compositor']) && $attrs['compositor'] != '') {
					$contentStr = '  <' . $schemaPrefix . ':' . $attrs['compositor'] . ">\n" . $contentStr . ('  </' . $schemaPrefix . ':' . $attrs['compositor'] . ">\n");
				}
			}

			if (isset($attrs['attrs']) && 1 <= count($attrs['attrs'])) {
				foreach ($attrs['attrs'] as $attr => $aParts) {
					$contentStr .= '    <' . $schemaPrefix . ':attribute';

					foreach ($aParts as $a => $v) {
						if ($a == 'ref' || $a == 'type') {
							$contentStr .= ' ' . $a . '="' . $this->contractQName($v) . '"';
						}
						else if ($a == 'http://schemas.xmlsoap.org/wsdl/:arrayType') {
							$this->usedNamespaces['wsdl'] = $this->namespaces['wsdl'];
							$contentStr .= ' wsdl:arrayType="' . $this->contractQName($v) . '"';
						}
						else {
							$contentStr .= ' ' . $a . '="' . $v . '"';
						}
					}

					$contentStr .= "/>\n";
				}
			}

			if (isset($attrs['restrictionBase']) && $attrs['restrictionBase'] != '') {
				$contentStr = '   <' . $schemaPrefix . ':restriction base="' . $this->contractQName($attrs['restrictionBase']) . "\">\n" . $contentStr . ('   </' . $schemaPrefix . ":restriction>\n");
				if (isset($attrs['elements']) && 0 < count($attrs['elements']) || isset($attrs['attrs']) && 0 < count($attrs['attrs'])) {
					$contentStr = '  <' . $schemaPrefix . ":complexContent>\n" . $contentStr . ('  </' . $schemaPrefix . ":complexContent>\n");
				}
			}

			if ($contentStr != '') {
				$contentStr = ' <' . $schemaPrefix . ':complexType name="' . $typeName . "\">\n" . $contentStr . (' </' . $schemaPrefix . ":complexType>\n");
			}
			else {
				$contentStr = ' <' . $schemaPrefix . ':complexType name="' . $typeName . "\"/>\n";
			}

			$xml .= $contentStr;
		}

		if (isset($this->simpleTypes) && 0 < count($this->simpleTypes)) {
			foreach ($this->simpleTypes as $typeName => $eParts) {
				$xml .= ' <' . $schemaPrefix . ':simpleType name="' . $typeName . "\">\n  <" . $schemaPrefix . ':restriction base="' . $this->contractQName($eParts['type']) . "\">\n";

				if (isset($eParts['enumeration'])) {
					foreach ($eParts['enumeration'] as $e) {
						$xml .= '  <' . $schemaPrefix . ':enumeration value="' . $e . "\"/>\n";
					}
				}

				$xml .= '  </' . $schemaPrefix . ":restriction>\n </" . $schemaPrefix . ':simpleType>';
			}
		}

		if (isset($this->elements) && 0 < count($this->elements)) {
			foreach ($this->elements as $element => $eParts) {
				$xml .= ' <' . $schemaPrefix . ':element name="' . $element . '" type="' . $this->contractQName($eParts['type']) . "\"/>\n";
			}
		}

		if (isset($this->attributes) && 0 < count($this->attributes)) {
			foreach ($this->attributes as $attr => $aParts) {
				$xml .= ' <' . $schemaPrefix . ':attribute name="' . $attr . '" type="' . $this->contractQName($aParts['type']) . "\"\n/>";
			}
		}

		$attr = '';

		foreach ($this->schemaInfo as $k => $v) {
			if ($k == 'elementFormDefault' || $k == 'attributeFormDefault') {
				$attr .= ' ' . $k . '="' . $v . '"';
			}
		}

		$el = '<' . $schemaPrefix . ':schema' . $attr . ' targetNamespace="' . $this->schemaTargetNamespace . "\"\n";

		foreach (array_diff($this->usedNamespaces, $this->enclosingNamespaces) as $nsp => $ns) {
			$el .= ' xmlns:' . $nsp . '="' . $ns . '"';
		}

		$xml = $el . ">\n" . $xml . ('</' . $schemaPrefix . ":schema>\n");
		return $xml;
	}

	/**
	* adds debug data to the clas level debug string
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function xdebug($string)
	{
		$this->debug('<' . $this->schemaTargetNamespace . '> ' . $string);
	}

	/**
    * get the PHP type of a user defined type in the schema
    * PHP type is kind of a misnomer since it actually returns 'struct' for assoc. arrays
    * returns false if no type exists, or not w/ the given namespace
    * else returns a string that is either a native php type, or 'struct'
    *
    * @param string $type name of defined type
    * @param string $ns namespace of type
    * @return mixed
    * @access public
    * @deprecated
    */
	public function getPHPType($type, $ns)
	{
		if (isset($this->typemap[$ns][$type])) {
			return $this->typemap[$ns][$type];
		}

		if (isset($this->complexTypes[$type])) {
			return $this->complexTypes[$type]['phpType'];
		}

		return false;
	}

	/**
    * returns an associative array of information about a given type
    * returns false if no type exists by the given name
    *
	*	For a complexType typeDef = array(
	*	'restrictionBase' => '',
	*	'phpType' => '',
	*	'compositor' => '(sequence|all)',
	*	'elements' => array(), // refs to elements array
	*	'attrs' => array() // refs to attributes array
	*	... and so on (see addComplexType)
	*	)
	*
	*   For simpleType or element, the array has different keys.
    *
    * @param string $type
    * @return mixed
    * @access public
    * @see addComplexType
    * @see addSimpleType
    * @see addElement
    */
	public function getTypeDef($type)
	{
		if (substr($type, -1) == '^') {
			$is_element = 1;
			$type = substr($type, 0, -1);
		}
		else {
			$is_element = 0;
		}

		if (!$is_element && isset($this->complexTypes[$type])) {
			$this->xdebug('in getTypeDef, found complexType ' . $type);
			return $this->complexTypes[$type];
		}

		if (!$is_element && isset($this->simpleTypes[$type])) {
			$this->xdebug('in getTypeDef, found simpleType ' . $type);

			if (!isset($this->simpleTypes[$type]['phpType'])) {
				$uqType = substr($this->simpleTypes[$type]['type'], strrpos($this->simpleTypes[$type]['type'], ':') + 1);
				$ns = substr($this->simpleTypes[$type]['type'], 0, strrpos($this->simpleTypes[$type]['type'], ':'));
				$etype = $this->getTypeDef($uqType);

				if ($etype) {
					$this->xdebug('in getTypeDef, found type for simpleType ' . $type . ':');
					$this->xdebug($this->varDump($etype));

					if (isset($etype['phpType'])) {
						$this->simpleTypes[$type]['phpType'] = $etype['phpType'];
					}

					if (isset($etype['elements'])) {
						$this->simpleTypes[$type]['elements'] = $etype['elements'];
					}
				}
			}

			return $this->simpleTypes[$type];
		}

		if (isset($this->elements[$type])) {
			$this->xdebug('in getTypeDef, found element ' . $type);

			if (!isset($this->elements[$type]['phpType'])) {
				$uqType = substr($this->elements[$type]['type'], strrpos($this->elements[$type]['type'], ':') + 1);
				$ns = substr($this->elements[$type]['type'], 0, strrpos($this->elements[$type]['type'], ':'));
				$etype = $this->getTypeDef($uqType);

				if ($etype) {
					$this->xdebug('in getTypeDef, found type for element ' . $type . ':');
					$this->xdebug($this->varDump($etype));

					if (isset($etype['phpType'])) {
						$this->elements[$type]['phpType'] = $etype['phpType'];
					}

					if (isset($etype['elements'])) {
						$this->elements[$type]['elements'] = $etype['elements'];
					}

					if (isset($etype['extensionBase'])) {
						$this->elements[$type]['extensionBase'] = $etype['extensionBase'];
					}
				}
				else {
					if ($ns == 'http://www.w3.org/2001/XMLSchema') {
						$this->xdebug('in getTypeDef, element ' . $type . ' is an XSD type');
						$this->elements[$type]['phpType'] = 'scalar';
					}
				}
			}

			return $this->elements[$type];
		}

		if (isset($this->attributes[$type])) {
			$this->xdebug('in getTypeDef, found attribute ' . $type);
			return $this->attributes[$type];
		}

		if (preg_match('/_ContainedType$/', $type)) {
			$this->xdebug('in getTypeDef, have an untyped element ' . $type);
			$typeDef['typeClass'] = 'simpleType';
			$typeDef['phpType'] = 'scalar';
			$typeDef['type'] = 'http://www.w3.org/2001/XMLSchema:string';
			return $typeDef;
		}

		$this->xdebug('in getTypeDef, did not find ' . $type);
		return false;
	}

	/**
    * returns a sample serialization of a given type, or false if no type by the given name
    *
    * @param string $type name of type
    * @return mixed
    * @access public
    * @deprecated
    */
	public function serializeTypeDef($type)
	{
		if ($typeDef = $this->getTypeDef($type)) {
			$str .= '<' . $type;

			if (is_array($typeDef['attrs'])) {
				foreach ($typeDef['attrs'] as $attName => $data) {
					$str .= ' ' . $attName . '="{type = ' . $data['type'] . '}"';
				}
			}

			$str .= ' xmlns="' . $this->schema['targetNamespace'] . '"';

			if (0 < count($typeDef['elements'])) {
				$str .= '>';

				foreach ($typeDef['elements'] as $element => $eData) {
					$str .= $this->serializeTypeDef($element);
				}

				$str .= '</' . $type . '>';
			}
			else if ($typeDef['typeClass'] == 'element') {
				$str .= '></' . $type . '>';
			}
			else {
				$str .= '/>';
			}

			return $str;
		}

		return false;
	}

	/**
    * returns HTML form elements that allow a user
    * to enter values for creating an instance of the given type.
    *
    * @param string $name name for type instance
    * @param string $type name of type
    * @return string
    * @access public
    * @deprecated
	*/
	public function typeToForm($name, $type)
	{
		if ($typeDef = $this->getTypeDef($type)) {
			if ($typeDef['phpType'] == 'struct') {
				$buffer .= '<table>';

				foreach ($typeDef['elements'] as $child => $childDef) {
					$buffer .= "\r\n\t\t\t\t\t<tr><td align='right'>" . $childDef['name'] . ' (type: ' . $this->getLocalPart($childDef['type']) . "):</td>\r\n\t\t\t\t\t<td><input type='text' name='parameters[" . $name . ('][' . $childDef['name'] . ']\'></td></tr>');
				}

				$buffer .= '</table>';
			}
			else if ($typeDef['phpType'] == 'array') {
				$buffer .= '<table>';
				$i = 0;

				while ($i < 3) {
					$buffer .= "\r\n\t\t\t\t\t<tr><td align='right'>array item (type: " . $typeDef['arrayType'] . "):</td>\r\n\t\t\t\t\t<td><input type='text' name='parameters[" . $name . '][]\'></td></tr>';
					++$i;
				}

				$buffer .= '</table>';
			}
			else {
				$buffer .= '<input type=\'text\' name=\'parameters[' . $name . ']\'>';
			}
		}
		else {
			$buffer .= '<input type=\'text\' name=\'parameters[' . $name . ']\'>';
		}

		return $buffer;
	}

	/**
	* adds a complex type to the schema
	* 
	* example: array
	* 
	* addType(
	* 	'ArrayOfstring',
	* 	'complexType',
	* 	'array',
	* 	'',
	* 	'SOAP-ENC:Array',
	* 	array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'string[]'),
	* 	'xsd:string'
	* );
	* 
	* example: PHP associative array ( SOAP Struct )
	* 
	* addType(
	* 	'SOAPStruct',
	* 	'complexType',
	* 	'struct',
	* 	'all',
	* 	array('myVar'=> array('name'=>'myVar','type'=>'string')
	* );
	* 
	* @param name
	* @param typeClass (complexType|simpleType|attribute)
	* @param phpType: currently supported are array and struct (php assoc array)
	* @param compositor (all|sequence|choice)
	* @param restrictionBase namespace:name (http://schemas.xmlsoap.org/soap/encoding/:Array)
	* @param elements = array ( name = array(name=>'',type=>'') )
	* @param attrs = array(
	* 	array(
	*		'ref' => "http://schemas.xmlsoap.org/soap/encoding/:arrayType",
	*		"http://schemas.xmlsoap.org/wsdl/:arrayType" => "string[]"
	* 	)
	* )
	* @param arrayType: namespace:name (http://www.w3.org/2001/XMLSchema:string)
	* @access public
	* @see getTypeDef
	*/
	public function addComplexType($name, $typeClass = 'complexType', $phpType = 'array', $compositor = '', $restrictionBase = '', $elements = array(), $attrs = array(), $arrayType = '')
	{
		$this->complexTypes[$name] = array('name' => $name, 'typeClass' => $typeClass, 'phpType' => $phpType, 'compositor' => $compositor, 'restrictionBase' => $restrictionBase, 'elements' => $elements, 'attrs' => $attrs, 'arrayType' => $arrayType);
		$this->xdebug('addComplexType ' . $name . ':');
		$this->appendDebug($this->varDump($this->complexTypes[$name]));
	}

	/**
	* adds a simple type to the schema
	*
	* @param string $name
	* @param string $restrictionBase namespace:name (http://schemas.xmlsoap.org/soap/encoding/:Array)
	* @param string $typeClass (should always be simpleType)
	* @param string $phpType (should always be scalar)
	* @param array $enumeration array of values
	* @access public
	* @see nusoap_xmlschema
	* @see getTypeDef
	*/
	public function addSimpleType($name, $restrictionBase = '', $typeClass = 'simpleType', $phpType = 'scalar', $enumeration = array())
	{
		$this->simpleTypes[$name] = array('name' => $name, 'typeClass' => $typeClass, 'phpType' => $phpType, 'type' => $restrictionBase, 'enumeration' => $enumeration);
		$this->xdebug('addSimpleType ' . $name . ':');
		$this->appendDebug($this->varDump($this->simpleTypes[$name]));
	}

	/**
	* adds an element to the schema
	*
	* @param array $attrs attributes that must include name and type
	* @see nusoap_xmlschema
	* @access public
	*/
	public function addElement($attrs)
	{
		if (!$this->getPrefix($attrs['type'])) {
			$attrs['type'] = $this->schemaTargetNamespace . ':' . $attrs['type'];
		}

		$this->elements[$attrs['name']] = $attrs;
		$this->elements[$attrs['name']]['typeClass'] = 'element';
		$this->xdebug('addElement ' . $attrs['name']);
		$this->appendDebug($this->varDump($this->elements[$attrs['name']]));
	}

	/**
	* constructor
	*
	* @access	public
	*/
	public function nusoap_base()
	{
		$this->debugLevel = $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* gets the global debug level, which applies to future instances
	*
	* @return	integer	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getGlobalDebugLevel()
	{
		return $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* sets the global debug level, which applies to future instances
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setGlobalDebugLevel($level)
	{
		$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = $level;
	}

	/**
	* gets the debug level for this instance
	*
	* @return	int	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}

	/**
	* sets the debug level for this instance
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}

	/**
	* adds debug data to the instance debug string with formatting
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function debug($string)
	{
		if (0 < $this->debugLevel) {
			$this->appendDebug($this->getmicrotime() . ' ' . get_class($this) . (': ' . $string . "\n"));
		}
	}

	/**
	* adds debug data to the instance debug string without formatting
	*
	* @param    string $string debug data
	* @access   public
	*/
	public function appendDebug($string)
	{
		if (0 < $this->debugLevel) {
			$this->debug_str .= $string;
		}
	}

	/**
	* clears the current debug data for this instance
	*
	* @access   public
	*/
	public function clearDebug()
	{
		$this->debug_str = '';
	}

	/**
	* gets the current debug data for this instance
	*
	* @return   debug data
	* @access   public
	*/
	public function& getDebug()
	{
		return $this->debug_str;
	}

	/**
	* gets the current debug data for this instance as an XML comment
	* this may change the contents of the debug data
	*
	* @return   debug data as an XML comment
	* @access   public
	*/
	public function& getDebugAsXMLComment()
	{
		while (strpos($this->debug_str, '--')) {
			$this->debug_str = str_replace('--', '- -', $this->debug_str);
		}

		$ret = "<!--\n" . $this->debug_str . "\n-->";
		return $ret;
	}

	/**
	* expands entities, e.g. changes '<' to '&lt;'.
	*
	* @param	string	$val	The string in which to expand entities.
	* @access	private
	*/
	public function expandEntities($val)
	{
		if ($this->charencoding) {
			$val = str_replace('&', '&amp;', $val);
			$val = str_replace('\'', '&apos;', $val);
			$val = str_replace('"', '&quot;', $val);
			$val = str_replace('<', '&lt;', $val);
			$val = str_replace('>', '&gt;', $val);
		}

		return $val;
	}

	/**
	* returns error string if present
	*
	* @return   mixed error string or false
	* @access   public
	*/
	public function getError()
	{
		if ($this->error_str != '') {
			return $this->error_str;
		}

		return false;
	}

	/**
	* sets error string
	*
	* @return   boolean $string error string
	* @access   private
	*/
	public function setError($str)
	{
		$this->error_str = $str;
	}

	/**
	* detect if array is a simple array or a struct (associative array)
	*
	* @param	mixed	$val	The PHP array
	* @return	string	(arraySimple|arrayStruct)
	* @access	private
	*/
	public function isArraySimpleOrStruct($val)
	{
		$keyList = array_keys($val);

		foreach ($keyList as $keyListValue) {
			if (!is_int($keyListValue)) {
				return 'arrayStruct';
			}
		}

		return 'arraySimple';
	}

	/**
	* serializes PHP values in accordance w/ section 5. Type information is
	* not serialized if $use == 'literal'.
	*
	* @param	mixed	$val	The value to serialize
	* @param	string	$name	The name (local part) of the XML element
	* @param	string	$type	The XML schema type (local part) for the element
	* @param	string	$name_ns	The namespace for the name of the XML element
	* @param	string	$type_ns	The namespace for the type of the element
	* @param	array	$attributes	The attributes to serialize as name=>value pairs
	* @param	string	$use	The WSDL "use" (encoded|literal)
	* @param	boolean	$soapval	Whether this is called from soapval.
	* @return	string	The serialized element, possibly with child elements
    * @access	public
	*/
	public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = 'encoded', $soapval = false)
	{
		$this->debug('in serialize_val: name=' . $name . ', type=' . $type . ', name_ns=' . $name_ns . ', type_ns=' . $type_ns . ', use=' . $use . ', soapval=' . $soapval);
		$this->appendDebug('value=' . $this->varDump($val));
		$this->appendDebug('attributes=' . $this->varDump($attributes));
		if (is_object($val) && get_class($val) == 'soapval' && !$soapval) {
			$this->debug('serialize_val: serialize soapval');
			$xml = $val->serialize($use);
			$this->appendDebug($val->getDebug());
			$val->clearDebug();
			$this->debug('serialize_val of soapval returning ' . $xml);
			return $xml;
		}

		if (is_numeric($name)) {
			$name = '__numeric_' . $name;
		}
		else {
			if (!$name) {
				$name = 'noname';
			}
		}

		$xmlns = '';

		if ($name_ns) {
			$prefix = 'nu' . rand(1000, 9999);
			$name = $prefix . ':' . $name;
			$xmlns .= ' xmlns:' . $prefix . '="' . $name_ns . '"';
		}

		if ($type_ns != '' && $type_ns == $this->namespaces['xsd']) {
			$type_prefix = 'xsd';
		}
		else {
			if ($type_ns) {
				$type_prefix = 'ns' . rand(1000, 9999);
				$xmlns .= ' xmlns:' . $type_prefix . '="' . $type_ns . '"';
			}
		}

		$atts = '';

		if ($attributes) {
			foreach ($attributes as $k => $v) {
				$atts .= ' ' . $k . '="' . $this->expandEntities($v) . '"';
			}
		}

		if (is_null($val)) {
			$this->debug('serialize_val: serialize null');

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '/>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			$xml = '<' . $name . $xmlns . $type_str . $atts . ' xsi:nil="true"/>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		if ($type != '' && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
			$this->debug('serialize_val: serialize xsd built-in primitive type');

			if (is_bool($val)) {
				if ($type == 'boolean') {
					$val = $val ? 'true' : 'false';
				}
				else {
					if (!$val) {
						$val = 0;
					}
				}
			}
			else {
				if (is_string($val)) {
					$val = $this->expandEntities($val);
				}
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			$xml = '<' . $name . $xmlns . ' xsi:type="xsd:' . $type . '"' . $atts . '>' . $val . '</' . $name . '>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		$xml = '';
		switch (true) {
		case is_bool($val) || $type == 'boolean':
			$this->debug('serialize_val: serialize boolean');

			if ($type == 'boolean') {
				$val = $val ? 'true' : 'false';
			}
			else {
				if (!$val) {
					$val = 0;
				}
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:boolean"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_int($val) || is_long($val) || $type == 'int':
			$this->debug('serialize_val: serialize int');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:int"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_float($val) || is_double($val) || $type == 'float':
			$this->debug('serialize_val: serialize float');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:float"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_string($val) || $type == 'string':
			$this->debug('serialize_val: serialize string');
			$val = $this->expandEntities($val);

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:string"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_object($val):
			$this->debug('serialize_val: serialize object');

			if (get_class($val) == 'soapval') {
				$this->debug('serialize_val: serialize soapval object');
				$pXml = $val->serialize($use);
				$this->appendDebug($val->getDebug());
				$val->clearDebug();
			}
			else {
				if (!$name) {
					$name = get_class($val);
					$this->debug('In serialize_val, used class name ' . $name . ' as element name');
				}
				else {
					$this->debug('In serialize_val, do not override name ' . $name . ' for element name for class ' . get_class($val));
				}

				foreach (get_object_vars($val) as $k => $v) {
					$pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $pXml . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . $type_str . $atts . '>' . $pXml . '</' . $name . '>';
			}

			break;

		case is_array($val) || $type:
			$valueType = $this->isArraySimpleOrStruct($val);
			if ($valueType == 'arraySimple' || preg_match('/^ArrayOf/', $type)) {
				$this->debug('serialize_val: serialize array');
				$i = 0;
				if (is_array($val) && 0 < count($val)) {
					foreach ($val as $v) {
						if (is_object($v) && get_class($v) == 'soapval') {
							$tt_ns = $v->type_ns;
							$tt = $v->type;
						}
						else if (is_array($v)) {
							$tt = $this->isArraySimpleOrStruct($v);
						}
						else {
							$tt = gettype($v);
						}

						$array_types[$tt] = 1;
						$xml .= $this->serialize_val($v, 'item', false, false, false, false, $use);
						++$i;
					}

					if (1 < count($array_types)) {
						$array_typename = 'xsd:anyType';
					}
					else {
						if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
							if ($tt == 'integer') {
								$tt = 'int';
							}

							$array_typename = 'xsd:' . $tt;
						}
						else {
							if (isset($tt) && $tt == 'arraySimple') {
								$array_typename = 'SOAP-ENC:Array';
							}
							else {
								if (isset($tt) && $tt == 'arrayStruct') {
									$array_typename = 'unnamed_struct_use_soapval';
								}
								else {
									if ($tt_ns != '' && $tt_ns == $this->namespaces['xsd']) {
										$array_typename = 'xsd:' . $tt;
									}
									else if ($tt_ns) {
										$tt_prefix = 'ns' . rand(1000, 9999);
										$array_typename = $tt_prefix . ':' . $tt;
										$xmlns .= ' xmlns:' . $tt_prefix . '="' . $tt_ns . '"';
									}
									else {
										$array_typename = $tt;
									}
								}
							}
						}
					}

					$array_type = $i;

					if ($use == 'literal') {
						$type_str = '';
					}
					else {
						if (isset($type) && isset($type_prefix)) {
							$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
						}
						else {
							$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="' . $array_typename . ('[' . $array_type . ']"');
						}
					}
				}
				else if ($use == 'literal') {
					$type_str = '';
				}
				else {
					if (isset($type) && isset($type_prefix)) {
						$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
					}
					else {
						$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="xsd:anyType[0]"';
					}
				}

				$xml = '<' . $name . $xmlns . $type_str . $atts . '>' . $xml . ('</' . $name . '>');
			}
			else {
				$this->debug('serialize_val: serialize struct');
				if (isset($type) && isset($type_prefix)) {
					$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
				}
				else {
					$type_str = '';
				}

				if ($use == 'literal') {
					$xml .= '<' . $name . $xmlns . $atts . '>';
				}
				else {
					$xml .= '<' . $name . $xmlns . $type_str . $atts . '>';
				}

				foreach ($val as $k => $v) {
					if ($type == 'Map' && $type_ns == 'http://xml.apache.org/xml-soap') {
						$xml .= '<item>';
						$xml .= $this->serialize_val($k, 'key', false, false, false, false, $use);
						$xml .= $this->serialize_val($v, 'value', false, false, false, false, $use);
						$xml .= '</item>';
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$xml .= '</' . $name . '>';
			}

			break;

		default:
			$this->debug('serialize_val: serialize unknown');
			$xml .= 'not detected, got ' . gettype($val) . ' for ' . $val;
			break;
		}

		$this->debug('serialize_val returning ' . $xml);
		return $xml;
	}

	/**
    * serializes a message
    *
    * @param string $body the XML of the SOAP body
    * @param mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
    * @param array $namespaces optional the namespaces used in generating the body and headers
    * @param string $style optional (rpc|document)
    * @param string $use optional (encoded|literal)
    * @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
    * @return string the message
    * @access public
    */
	public function serializeEnvelope($body, $headers = false, $namespaces = array(), $style = 'rpc', $use = 'encoded', $encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/')
	{
		$this->debug('In serializeEnvelope length=' . strlen($body) . ' body (max 1000 characters)=' . substr($body, 0, 1000) . (' style=' . $style . ' use=' . $use . ' encodingStyle=' . $encodingStyle));
		$this->debug('headers:');
		$this->appendDebug($this->varDump($headers));
		$this->debug('namespaces:');
		$this->appendDebug($this->varDump($namespaces));
		$ns_string = '';

		foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
			$ns_string .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if ($encodingStyle) {
			$ns_string = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"' . $ns_string;
		}

		if ($headers) {
			if (is_array($headers)) {
				$xml = '';

				foreach ($headers as $k => $v) {
					if (is_object($v) && get_class($v) == 'soapval') {
						$xml .= $this->serialize_val($v, false, false, false, false, false, $use);
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$headers = $xml;
				$this->debug('In serializeEnvelope, serialized array of headers to ' . $headers);
			}

			$headers = '<SOAP-ENV:Header>' . $headers . '</SOAP-ENV:Header>';
		}

		return '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?' . '>' . '<SOAP-ENV:Envelope' . $ns_string . '>' . $headers . '<SOAP-ENV:Body>' . $body . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
	}

	/**
	 * formats a string to be inserted into an HTML stream
	 *
	 * @param string $str The string to format
	 * @return string The formatted string
	 * @access public
	 * @deprecated
	 */
	public function formatDump($str)
	{
		$str = htmlspecialchars($str);
		return nl2br($str);
	}

	/**
	* contracts (changes namespace to prefix) a qualified name
	*
	* @param    string $qname qname
	* @return	string contracted qname
	* @access   private
	*/
	public function contractQname($qname)
	{
		if (strrpos($qname, ':')) {
			$name = substr($qname, strrpos($qname, ':') + 1);
			$ns = substr($qname, 0, strrpos($qname, ':'));
			$p = $this->getPrefixFromNamespace($ns);

			if ($p) {
				return $p . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
	* expands (changes prefix to namespace) a qualified name
	*
	* @param    string $qname qname
	* @return	string expanded qname
	* @access   private
	*/
	public function expandQname($qname)
	{
		if (strpos($qname, ':') && !preg_match('/^http:\\/\\//', $qname)) {
			$name = substr(strstr($qname, ':'), 1);
			$prefix = substr($qname, 0, strpos($qname, ':'));

			if (isset($this->namespaces[$prefix])) {
				return $this->namespaces[$prefix] . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
    * returns the local part of a prefixed string
    * returns the original string, if not prefixed
    *
    * @param string $str The prefixed string
    * @return string The local part
    * @access public
    */
	public function getLocalPart($str)
	{
		if ($sstr = strrchr($str, ':')) {
			return substr($sstr, 1);
		}

		return $str;
	}

	/**
    * returns the prefix part of a prefixed string
    * returns false, if not prefixed
    *
    * @param string $str The prefixed string
    * @return mixed The prefix or false if there is no prefix
    * @access public
    */
	public function getPrefix($str)
	{
		if ($pos = strrpos($str, ':')) {
			return substr($str, 0, $pos);
		}

		return false;
	}

	/**
    * pass it a prefix, it returns a namespace
    *
    * @param string $prefix The prefix
    * @return mixed The namespace, false if no namespace has the specified prefix
    * @access public
    */
	public function getNamespaceFromPrefix($prefix)
	{
		if (isset($this->namespaces[$prefix])) {
			return $this->namespaces[$prefix];
		}

		return false;
	}

	/**
    * returns the prefix for a given namespace (or prefix)
    * or false if no prefixes registered for the given namespace
    *
    * @param string $ns The namespace
    * @return mixed The prefix, false if the namespace has no prefixes
    * @access public
    */
	public function getPrefixFromNamespace($ns)
	{
		foreach ($this->namespaces as $p => $n) {
			if ($ns == $n || $ns == $p) {
				$this->usedNamespaces[$p] = $n;
				return $p;
			}
		}

		return false;
	}

	/**
    * returns the time in ODBC canonical form with microseconds
    *
    * @return string The time in ODBC canonical form with microseconds
    * @access public
    */
	public function getmicrotime()
	{
		if (function_exists('gettimeofday')) {
			$tod = gettimeofday();
			$sec = $tod['sec'];
			$usec = $tod['usec'];
		}
		else {
			$sec = time();
			$usec = 0;
		}

		return strftime('%Y-%m-%d %H:%M:%S', $sec) . '.' . sprintf('%06d', $usec);
	}

	/**
	 * Returns a string with the output of var_dump
	 *
	 * @param mixed $data The variable to var_dump
	 * @return string The output of var_dump
	 * @access public
	 */
	public function varDump($data)
	{
		ob_start();
		var_dump($data);
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	/**
	* represents the object as a string
	*
	* @return	string
	* @access   public
	*/
	public function __toString()
	{
		return $this->varDump($this);
	}
}

class soapval extends nusoap_base
{
	/**
	 * The XML element name
	 *
	 * @var string
	 * @access private
	 */
	public $name;
	/**
	 * The XML type name (string or false)
	 *
	 * @var mixed
	 * @access private
	 */
	public $type;
	/**
	 * The PHP value
	 *
	 * @var mixed
	 * @access private
	 */
	public $value;
	/**
	 * The XML element namespace (string or false)
	 *
	 * @var mixed
	 * @access private
	 */
	public $element_ns;
	/**
	 * The XML type namespace (string or false)
	 *
	 * @var mixed
	 * @access private
	 */
	public $type_ns;
	/**
	 * The XML element attributes (array or false)
	 *
	 * @var mixed
	 * @access private
	 */
	public $attributes;
	/**
	 * Identification for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $title = 'NuSOAP';
	/**
	 * Version for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $version = '0.9.5';
	/**
	 * CVS revision for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $revision = '$Revision: 1.123 $';
	/**
     * Current error string (manipulated by getError/setError)
	 *
	 * @var string
	 * @access private
	 */
	public $error_str = '';
	/**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
	 *
	 * @var string
	 * @access private
	 */
	public $debug_str = '';
	/**
	 * toggles automatic encoding of special characters as entities
	 * (should always be true, I think)
	 *
	 * @var boolean
	 * @access private
	 */
	public $charencoding = true;
	/**
	 * the debug level for this instance
	 *
	 * @var	integer
	 * @access private
	 */
	public $debugLevel;
	/**
	* set schema version
	*
	* @var      string
	* @access   public
	*/
	public $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';
	/**
	* charset encoding for outgoing messages
	*
	* @var      string
	* @access   public
	*/
	public $soap_defencoding = 'ISO-8859-1';
	/**
	* namespaces in an array of prefix => uri
	*
	* this is "seeded" by a set of constants, but it may be altered by code
	*
	* @var      array
	* @access   public
	*/
	public $namespaces = array('SOAP-ENV' => 'http://schemas.xmlsoap.org/soap/envelope/', 'xsd' => 'http://www.w3.org/2001/XMLSchema', 'xsi' => 'http://www.w3.org/2001/XMLSchema-instance', 'SOAP-ENC' => 'http://schemas.xmlsoap.org/soap/encoding/');
	/**
	* namespaces used in the current context, e.g. during serialization
	*
	* @var      array
	* @access   private
	*/
	public $usedNamespaces = array();
	/**
	* XML Schema types in an array of uri => (array of xml type => php type)
	* is this legacy yet?
	* no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
	* @var      array
	* @access   public
	*/
	public $typemap = array(
		'http://www.w3.org/2001/XMLSchema'          => array('string' => 'string', 'boolean' => 'boolean', 'float' => 'double', 'double' => 'double', 'decimal' => 'double', 'duration' => '', 'dateTime' => 'string', 'time' => 'string', 'date' => 'string', 'gYearMonth' => '', 'gYear' => '', 'gMonthDay' => '', 'gDay' => '', 'gMonth' => '', 'hexBinary' => 'string', 'base64Binary' => 'string', 'anyType' => 'string', 'anySimpleType' => 'string', 'normalizedString' => 'string', 'token' => 'string', 'language' => '', 'NMTOKEN' => '', 'NMTOKENS' => '', 'Name' => '', 'NCName' => '', 'ID' => '', 'IDREF' => '', 'IDREFS' => '', 'ENTITY' => '', 'ENTITIES' => '', 'integer' => 'integer', 'nonPositiveInteger' => 'integer', 'negativeInteger' => 'integer', 'long' => 'integer', 'int' => 'integer', 'short' => 'integer', 'byte' => 'integer', 'nonNegativeInteger' => 'integer', 'unsignedLong' => '', 'unsignedInt' => '', 'unsignedShort' => '', 'unsignedByte' => '', 'positiveInteger' => ''),
		'http://www.w3.org/2000/10/XMLSchema'       => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://www.w3.org/1999/XMLSchema'          => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://soapinterop.org/xsd'                => array('SOAPStruct' => 'struct'),
		'http://schemas.xmlsoap.org/soap/encoding/' => array('base64' => 'string', 'array' => 'array', 'Array' => 'array'),
		'http://xml.apache.org/xml-soap'            => array('Map')
		);
	/**
	* XML entities to convert
	*
	* @var      array
	* @access   public
	* @deprecated
	* @see	expandEntities
	*/
	public $xmlEntities = array('quot' => '"', 'amp' => '&', 'lt' => '<', 'gt' => '>', 'apos' => '\'');

	/**
	* constructor
	*
	* @param    string $name optional name
	* @param    mixed $type optional type name
	* @param	mixed $value optional value
	* @param	mixed $element_ns optional namespace of value
	* @param	mixed $type_ns optional namespace of type
	* @param	mixed $attributes associative array of attributes to add to element serialization
	* @access   public
	*/
	public function soapval($name = 'soapval', $type = false, $value = -1, $element_ns = false, $type_ns = false, $attributes = false)
	{
		parent::nusoap_base();
		$this->name = $name;
		$this->type = $type;
		$this->value = $value;
		$this->element_ns = $element_ns;
		$this->type_ns = $type_ns;
		$this->attributes = $attributes;
	}

	/**
	* return serialized value
	*
	* @param	string $use The WSDL use value (encoded|literal)
	* @return	string XML data
	* @access   public
	*/
	public function serialize($use = 'encoded')
	{
		return $this->serialize_val($this->value, $this->name, $this->type, $this->element_ns, $this->type_ns, $this->attributes, $use, true);
	}

	/**
	* decodes a soapval object into a PHP native type
	*
	* @return	mixed
	* @access   public
	*/
	public function decode()
	{
		return $this->value;
	}

	/**
	* constructor
	*
	* @access	public
	*/
	public function nusoap_base()
	{
		$this->debugLevel = $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* gets the global debug level, which applies to future instances
	*
	* @return	integer	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getGlobalDebugLevel()
	{
		return $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* sets the global debug level, which applies to future instances
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setGlobalDebugLevel($level)
	{
		$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = $level;
	}

	/**
	* gets the debug level for this instance
	*
	* @return	int	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}

	/**
	* sets the debug level for this instance
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}

	/**
	* adds debug data to the instance debug string with formatting
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function debug($string)
	{
		if (0 < $this->debugLevel) {
			$this->appendDebug($this->getmicrotime() . ' ' . get_class($this) . (': ' . $string . "\n"));
		}
	}

	/**
	* adds debug data to the instance debug string without formatting
	*
	* @param    string $string debug data
	* @access   public
	*/
	public function appendDebug($string)
	{
		if (0 < $this->debugLevel) {
			$this->debug_str .= $string;
		}
	}

	/**
	* clears the current debug data for this instance
	*
	* @access   public
	*/
	public function clearDebug()
	{
		$this->debug_str = '';
	}

	/**
	* gets the current debug data for this instance
	*
	* @return   debug data
	* @access   public
	*/
	public function& getDebug()
	{
		return $this->debug_str;
	}

	/**
	* gets the current debug data for this instance as an XML comment
	* this may change the contents of the debug data
	*
	* @return   debug data as an XML comment
	* @access   public
	*/
	public function& getDebugAsXMLComment()
	{
		while (strpos($this->debug_str, '--')) {
			$this->debug_str = str_replace('--', '- -', $this->debug_str);
		}

		$ret = "<!--\n" . $this->debug_str . "\n-->";
		return $ret;
	}

	/**
	* expands entities, e.g. changes '<' to '&lt;'.
	*
	* @param	string	$val	The string in which to expand entities.
	* @access	private
	*/
	public function expandEntities($val)
	{
		if ($this->charencoding) {
			$val = str_replace('&', '&amp;', $val);
			$val = str_replace('\'', '&apos;', $val);
			$val = str_replace('"', '&quot;', $val);
			$val = str_replace('<', '&lt;', $val);
			$val = str_replace('>', '&gt;', $val);
		}

		return $val;
	}

	/**
	* returns error string if present
	*
	* @return   mixed error string or false
	* @access   public
	*/
	public function getError()
	{
		if ($this->error_str != '') {
			return $this->error_str;
		}

		return false;
	}

	/**
	* sets error string
	*
	* @return   boolean $string error string
	* @access   private
	*/
	public function setError($str)
	{
		$this->error_str = $str;
	}

	/**
	* detect if array is a simple array or a struct (associative array)
	*
	* @param	mixed	$val	The PHP array
	* @return	string	(arraySimple|arrayStruct)
	* @access	private
	*/
	public function isArraySimpleOrStruct($val)
	{
		$keyList = array_keys($val);

		foreach ($keyList as $keyListValue) {
			if (!is_int($keyListValue)) {
				return 'arrayStruct';
			}
		}

		return 'arraySimple';
	}

	/**
	* serializes PHP values in accordance w/ section 5. Type information is
	* not serialized if $use == 'literal'.
	*
	* @param	mixed	$val	The value to serialize
	* @param	string	$name	The name (local part) of the XML element
	* @param	string	$type	The XML schema type (local part) for the element
	* @param	string	$name_ns	The namespace for the name of the XML element
	* @param	string	$type_ns	The namespace for the type of the element
	* @param	array	$attributes	The attributes to serialize as name=>value pairs
	* @param	string	$use	The WSDL "use" (encoded|literal)
	* @param	boolean	$soapval	Whether this is called from soapval.
	* @return	string	The serialized element, possibly with child elements
    * @access	public
	*/
	public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = 'encoded', $soapval = false)
	{
		$this->debug('in serialize_val: name=' . $name . ', type=' . $type . ', name_ns=' . $name_ns . ', type_ns=' . $type_ns . ', use=' . $use . ', soapval=' . $soapval);
		$this->appendDebug('value=' . $this->varDump($val));
		$this->appendDebug('attributes=' . $this->varDump($attributes));
		if (is_object($val) && get_class($val) == 'soapval' && !$soapval) {
			$this->debug('serialize_val: serialize soapval');
			$xml = $val->serialize($use);
			$this->appendDebug($val->getDebug());
			$val->clearDebug();
			$this->debug('serialize_val of soapval returning ' . $xml);
			return $xml;
		}

		if (is_numeric($name)) {
			$name = '__numeric_' . $name;
		}
		else {
			if (!$name) {
				$name = 'noname';
			}
		}

		$xmlns = '';

		if ($name_ns) {
			$prefix = 'nu' . rand(1000, 9999);
			$name = $prefix . ':' . $name;
			$xmlns .= ' xmlns:' . $prefix . '="' . $name_ns . '"';
		}

		if ($type_ns != '' && $type_ns == $this->namespaces['xsd']) {
			$type_prefix = 'xsd';
		}
		else {
			if ($type_ns) {
				$type_prefix = 'ns' . rand(1000, 9999);
				$xmlns .= ' xmlns:' . $type_prefix . '="' . $type_ns . '"';
			}
		}

		$atts = '';

		if ($attributes) {
			foreach ($attributes as $k => $v) {
				$atts .= ' ' . $k . '="' . $this->expandEntities($v) . '"';
			}
		}

		if (is_null($val)) {
			$this->debug('serialize_val: serialize null');

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '/>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			$xml = '<' . $name . $xmlns . $type_str . $atts . ' xsi:nil="true"/>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		if ($type != '' && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
			$this->debug('serialize_val: serialize xsd built-in primitive type');

			if (is_bool($val)) {
				if ($type == 'boolean') {
					$val = $val ? 'true' : 'false';
				}
				else {
					if (!$val) {
						$val = 0;
					}
				}
			}
			else {
				if (is_string($val)) {
					$val = $this->expandEntities($val);
				}
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			$xml = '<' . $name . $xmlns . ' xsi:type="xsd:' . $type . '"' . $atts . '>' . $val . '</' . $name . '>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		$xml = '';
		switch (true) {
		case is_bool($val) || $type == 'boolean':
			$this->debug('serialize_val: serialize boolean');

			if ($type == 'boolean') {
				$val = $val ? 'true' : 'false';
			}
			else {
				if (!$val) {
					$val = 0;
				}
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:boolean"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_int($val) || is_long($val) || $type == 'int':
			$this->debug('serialize_val: serialize int');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:int"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_float($val) || is_double($val) || $type == 'float':
			$this->debug('serialize_val: serialize float');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:float"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_string($val) || $type == 'string':
			$this->debug('serialize_val: serialize string');
			$val = $this->expandEntities($val);

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:string"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_object($val):
			$this->debug('serialize_val: serialize object');

			if (get_class($val) == 'soapval') {
				$this->debug('serialize_val: serialize soapval object');
				$pXml = $val->serialize($use);
				$this->appendDebug($val->getDebug());
				$val->clearDebug();
			}
			else {
				if (!$name) {
					$name = get_class($val);
					$this->debug('In serialize_val, used class name ' . $name . ' as element name');
				}
				else {
					$this->debug('In serialize_val, do not override name ' . $name . ' for element name for class ' . get_class($val));
				}

				foreach (get_object_vars($val) as $k => $v) {
					$pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $pXml . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . $type_str . $atts . '>' . $pXml . '</' . $name . '>';
			}

			break;

		case is_array($val) || $type:
			$valueType = $this->isArraySimpleOrStruct($val);
			if ($valueType == 'arraySimple' || preg_match('/^ArrayOf/', $type)) {
				$this->debug('serialize_val: serialize array');
				$i = 0;
				if (is_array($val) && 0 < count($val)) {
					foreach ($val as $v) {
						if (is_object($v) && get_class($v) == 'soapval') {
							$tt_ns = $v->type_ns;
							$tt = $v->type;
						}
						else if (is_array($v)) {
							$tt = $this->isArraySimpleOrStruct($v);
						}
						else {
							$tt = gettype($v);
						}

						$array_types[$tt] = 1;
						$xml .= $this->serialize_val($v, 'item', false, false, false, false, $use);
						++$i;
					}

					if (1 < count($array_types)) {
						$array_typename = 'xsd:anyType';
					}
					else {
						if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
							if ($tt == 'integer') {
								$tt = 'int';
							}

							$array_typename = 'xsd:' . $tt;
						}
						else {
							if (isset($tt) && $tt == 'arraySimple') {
								$array_typename = 'SOAP-ENC:Array';
							}
							else {
								if (isset($tt) && $tt == 'arrayStruct') {
									$array_typename = 'unnamed_struct_use_soapval';
								}
								else {
									if ($tt_ns != '' && $tt_ns == $this->namespaces['xsd']) {
										$array_typename = 'xsd:' . $tt;
									}
									else if ($tt_ns) {
										$tt_prefix = 'ns' . rand(1000, 9999);
										$array_typename = $tt_prefix . ':' . $tt;
										$xmlns .= ' xmlns:' . $tt_prefix . '="' . $tt_ns . '"';
									}
									else {
										$array_typename = $tt;
									}
								}
							}
						}
					}

					$array_type = $i;

					if ($use == 'literal') {
						$type_str = '';
					}
					else {
						if (isset($type) && isset($type_prefix)) {
							$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
						}
						else {
							$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="' . $array_typename . ('[' . $array_type . ']"');
						}
					}
				}
				else if ($use == 'literal') {
					$type_str = '';
				}
				else {
					if (isset($type) && isset($type_prefix)) {
						$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
					}
					else {
						$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="xsd:anyType[0]"';
					}
				}

				$xml = '<' . $name . $xmlns . $type_str . $atts . '>' . $xml . ('</' . $name . '>');
			}
			else {
				$this->debug('serialize_val: serialize struct');
				if (isset($type) && isset($type_prefix)) {
					$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
				}
				else {
					$type_str = '';
				}

				if ($use == 'literal') {
					$xml .= '<' . $name . $xmlns . $atts . '>';
				}
				else {
					$xml .= '<' . $name . $xmlns . $type_str . $atts . '>';
				}

				foreach ($val as $k => $v) {
					if ($type == 'Map' && $type_ns == 'http://xml.apache.org/xml-soap') {
						$xml .= '<item>';
						$xml .= $this->serialize_val($k, 'key', false, false, false, false, $use);
						$xml .= $this->serialize_val($v, 'value', false, false, false, false, $use);
						$xml .= '</item>';
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$xml .= '</' . $name . '>';
			}

			break;

		default:
			$this->debug('serialize_val: serialize unknown');
			$xml .= 'not detected, got ' . gettype($val) . ' for ' . $val;
			break;
		}

		$this->debug('serialize_val returning ' . $xml);
		return $xml;
	}

	/**
    * serializes a message
    *
    * @param string $body the XML of the SOAP body
    * @param mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
    * @param array $namespaces optional the namespaces used in generating the body and headers
    * @param string $style optional (rpc|document)
    * @param string $use optional (encoded|literal)
    * @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
    * @return string the message
    * @access public
    */
	public function serializeEnvelope($body, $headers = false, $namespaces = array(), $style = 'rpc', $use = 'encoded', $encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/')
	{
		$this->debug('In serializeEnvelope length=' . strlen($body) . ' body (max 1000 characters)=' . substr($body, 0, 1000) . (' style=' . $style . ' use=' . $use . ' encodingStyle=' . $encodingStyle));
		$this->debug('headers:');
		$this->appendDebug($this->varDump($headers));
		$this->debug('namespaces:');
		$this->appendDebug($this->varDump($namespaces));
		$ns_string = '';

		foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
			$ns_string .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if ($encodingStyle) {
			$ns_string = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"' . $ns_string;
		}

		if ($headers) {
			if (is_array($headers)) {
				$xml = '';

				foreach ($headers as $k => $v) {
					if (is_object($v) && get_class($v) == 'soapval') {
						$xml .= $this->serialize_val($v, false, false, false, false, false, $use);
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$headers = $xml;
				$this->debug('In serializeEnvelope, serialized array of headers to ' . $headers);
			}

			$headers = '<SOAP-ENV:Header>' . $headers . '</SOAP-ENV:Header>';
		}

		return '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?' . '>' . '<SOAP-ENV:Envelope' . $ns_string . '>' . $headers . '<SOAP-ENV:Body>' . $body . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
	}

	/**
	 * formats a string to be inserted into an HTML stream
	 *
	 * @param string $str The string to format
	 * @return string The formatted string
	 * @access public
	 * @deprecated
	 */
	public function formatDump($str)
	{
		$str = htmlspecialchars($str);
		return nl2br($str);
	}

	/**
	* contracts (changes namespace to prefix) a qualified name
	*
	* @param    string $qname qname
	* @return	string contracted qname
	* @access   private
	*/
	public function contractQname($qname)
	{
		if (strrpos($qname, ':')) {
			$name = substr($qname, strrpos($qname, ':') + 1);
			$ns = substr($qname, 0, strrpos($qname, ':'));
			$p = $this->getPrefixFromNamespace($ns);

			if ($p) {
				return $p . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
	* expands (changes prefix to namespace) a qualified name
	*
	* @param    string $qname qname
	* @return	string expanded qname
	* @access   private
	*/
	public function expandQname($qname)
	{
		if (strpos($qname, ':') && !preg_match('/^http:\\/\\//', $qname)) {
			$name = substr(strstr($qname, ':'), 1);
			$prefix = substr($qname, 0, strpos($qname, ':'));

			if (isset($this->namespaces[$prefix])) {
				return $this->namespaces[$prefix] . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
    * returns the local part of a prefixed string
    * returns the original string, if not prefixed
    *
    * @param string $str The prefixed string
    * @return string The local part
    * @access public
    */
	public function getLocalPart($str)
	{
		if ($sstr = strrchr($str, ':')) {
			return substr($sstr, 1);
		}

		return $str;
	}

	/**
    * returns the prefix part of a prefixed string
    * returns false, if not prefixed
    *
    * @param string $str The prefixed string
    * @return mixed The prefix or false if there is no prefix
    * @access public
    */
	public function getPrefix($str)
	{
		if ($pos = strrpos($str, ':')) {
			return substr($str, 0, $pos);
		}

		return false;
	}

	/**
    * pass it a prefix, it returns a namespace
    *
    * @param string $prefix The prefix
    * @return mixed The namespace, false if no namespace has the specified prefix
    * @access public
    */
	public function getNamespaceFromPrefix($prefix)
	{
		if (isset($this->namespaces[$prefix])) {
			return $this->namespaces[$prefix];
		}

		return false;
	}

	/**
    * returns the prefix for a given namespace (or prefix)
    * or false if no prefixes registered for the given namespace
    *
    * @param string $ns The namespace
    * @return mixed The prefix, false if the namespace has no prefixes
    * @access public
    */
	public function getPrefixFromNamespace($ns)
	{
		foreach ($this->namespaces as $p => $n) {
			if ($ns == $n || $ns == $p) {
				$this->usedNamespaces[$p] = $n;
				return $p;
			}
		}

		return false;
	}

	/**
    * returns the time in ODBC canonical form with microseconds
    *
    * @return string The time in ODBC canonical form with microseconds
    * @access public
    */
	public function getmicrotime()
	{
		if (function_exists('gettimeofday')) {
			$tod = gettimeofday();
			$sec = $tod['sec'];
			$usec = $tod['usec'];
		}
		else {
			$sec = time();
			$usec = 0;
		}

		return strftime('%Y-%m-%d %H:%M:%S', $sec) . '.' . sprintf('%06d', $usec);
	}

	/**
	 * Returns a string with the output of var_dump
	 *
	 * @param mixed $data The variable to var_dump
	 * @return string The output of var_dump
	 * @access public
	 */
	public function varDump($data)
	{
		ob_start();
		var_dump($data);
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	/**
	* represents the object as a string
	*
	* @return	string
	* @access   public
	*/
	public function __toString()
	{
		return $this->varDump($this);
	}
}

class soap_transport_http extends nusoap_base
{
	public $url = '';
	public $uri = '';
	public $digest_uri = '';
	public $scheme = '';
	public $host = '';
	public $port = '';
	public $path = '';
	public $request_method = 'POST';
	public $protocol_version = '1.0';
	public $encoding = '';
	public $outgoing_headers = array();
	public $incoming_headers = array();
	public $incoming_cookies = array();
	public $outgoing_payload = '';
	public $incoming_payload = '';
	public $response_status_line;
	public $useSOAPAction = true;
	public $persistentConnection = false;
	public $ch = false;
	public $ch_options = array();
	public $use_curl = false;
	public $proxy;
	public $username = '';
	public $password = '';
	public $authtype = '';
	public $digestRequest = array();
	public $certRequest = array();
	/**
	 * Identification for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $title = 'NuSOAP';
	/**
	 * Version for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $version = '0.9.5';
	/**
	 * CVS revision for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $revision = '$Revision: 1.123 $';
	/**
     * Current error string (manipulated by getError/setError)
	 *
	 * @var string
	 * @access private
	 */
	public $error_str = '';
	/**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
	 *
	 * @var string
	 * @access private
	 */
	public $debug_str = '';
	/**
	 * toggles automatic encoding of special characters as entities
	 * (should always be true, I think)
	 *
	 * @var boolean
	 * @access private
	 */
	public $charencoding = true;
	/**
	 * the debug level for this instance
	 *
	 * @var	integer
	 * @access private
	 */
	public $debugLevel;
	/**
	* set schema version
	*
	* @var      string
	* @access   public
	*/
	public $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';
	/**
	* charset encoding for outgoing messages
	*
	* @var      string
	* @access   public
	*/
	public $soap_defencoding = 'ISO-8859-1';
	/**
	* namespaces in an array of prefix => uri
	*
	* this is "seeded" by a set of constants, but it may be altered by code
	*
	* @var      array
	* @access   public
	*/
	public $namespaces = array('SOAP-ENV' => 'http://schemas.xmlsoap.org/soap/envelope/', 'xsd' => 'http://www.w3.org/2001/XMLSchema', 'xsi' => 'http://www.w3.org/2001/XMLSchema-instance', 'SOAP-ENC' => 'http://schemas.xmlsoap.org/soap/encoding/');
	/**
	* namespaces used in the current context, e.g. during serialization
	*
	* @var      array
	* @access   private
	*/
	public $usedNamespaces = array();
	/**
	* XML Schema types in an array of uri => (array of xml type => php type)
	* is this legacy yet?
	* no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
	* @var      array
	* @access   public
	*/
	public $typemap = array(
		'http://www.w3.org/2001/XMLSchema'          => array('string' => 'string', 'boolean' => 'boolean', 'float' => 'double', 'double' => 'double', 'decimal' => 'double', 'duration' => '', 'dateTime' => 'string', 'time' => 'string', 'date' => 'string', 'gYearMonth' => '', 'gYear' => '', 'gMonthDay' => '', 'gDay' => '', 'gMonth' => '', 'hexBinary' => 'string', 'base64Binary' => 'string', 'anyType' => 'string', 'anySimpleType' => 'string', 'normalizedString' => 'string', 'token' => 'string', 'language' => '', 'NMTOKEN' => '', 'NMTOKENS' => '', 'Name' => '', 'NCName' => '', 'ID' => '', 'IDREF' => '', 'IDREFS' => '', 'ENTITY' => '', 'ENTITIES' => '', 'integer' => 'integer', 'nonPositiveInteger' => 'integer', 'negativeInteger' => 'integer', 'long' => 'integer', 'int' => 'integer', 'short' => 'integer', 'byte' => 'integer', 'nonNegativeInteger' => 'integer', 'unsignedLong' => '', 'unsignedInt' => '', 'unsignedShort' => '', 'unsignedByte' => '', 'positiveInteger' => ''),
		'http://www.w3.org/2000/10/XMLSchema'       => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://www.w3.org/1999/XMLSchema'          => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://soapinterop.org/xsd'                => array('SOAPStruct' => 'struct'),
		'http://schemas.xmlsoap.org/soap/encoding/' => array('base64' => 'string', 'array' => 'array', 'Array' => 'array'),
		'http://xml.apache.org/xml-soap'            => array('Map')
		);
	/**
	* XML entities to convert
	*
	* @var      array
	* @access   public
	* @deprecated
	* @see	expandEntities
	*/
	public $xmlEntities = array('quot' => '"', 'amp' => '&', 'lt' => '<', 'gt' => '>', 'apos' => '\'');

	/**
	* constructor
	*
	* @param string $url The URL to which to connect
	* @param array $curl_options User-specified cURL options
	* @param boolean $use_curl Whether to try to force cURL use
	* @access public
	*/
	public function soap_transport_http($url, $curl_options = NULL, $use_curl = false)
	{
		parent::nusoap_base();
		$this->debug('ctor url=' . $url . ' use_curl=' . $use_curl . ' curl_options:');
		$this->appendDebug($this->varDump($curl_options));
		$this->setURL($url);

		if (is_array($curl_options)) {
			$this->ch_options = $curl_options;
		}

		$this->use_curl = $use_curl;
		preg_match('/\\$Revisio' . 'n: ([^ ]+)/', $this->revision, $rev);
		$this->setHeader('User-Agent', $this->title . '/' . $this->version . ' (' . $rev[1] . ')');
	}

	/**
	* sets a cURL option
	*
	* @param	mixed $option The cURL option (always integer?)
	* @param	mixed $value The cURL option value
	* @access   private
	*/
	public function setCurlOption($option, $value)
	{
		$this->debug('setCurlOption option=' . $option . ', value=');
		$this->appendDebug($this->varDump($value));
		curl_setopt($this->ch, $option, $value);
	}

	/**
	* sets an HTTP header
	*
	* @param string $name The name of the header
	* @param string $value The value of the header
	* @access private
	*/
	public function setHeader($name, $value)
	{
		$this->outgoing_headers[$name] = $value;
		$this->debug('set header ' . $name . ': ' . $value);
	}

	/**
	* unsets an HTTP header
	*
	* @param string $name The name of the header
	* @access private
	*/
	public function unsetHeader($name)
	{
		if (isset($this->outgoing_headers[$name])) {
			$this->debug('unset header ' . $name);
			unset($this->outgoing_headers[$name]);
		}
	}

	/**
	* sets the URL to which to connect
	*
	* @param string $url The URL to which to connect
	* @access private
	*/
	public function setURL($url)
	{
		$this->url = $url;
		$u = parse_url($url);

		foreach ($u as $k => $v) {
			$this->debug('parsed URL ' . $k . ' = ' . $v);
			$this->$k = $v;
		}

		if (isset($u['query']) && $u['query'] != '') {
			$this->path .= '?' . $u['query'];
		}

		if (!isset($u['port'])) {
			if ($u['scheme'] == 'https') {
				$this->port = 443;
			}
			else {
				$this->port = 80;
			}
		}

		$this->uri = $this->path;
		$this->digest_uri = $this->uri;

		if (!isset($u['port'])) {
			$this->setHeader('Host', $this->host);
		}
		else {
			$this->setHeader('Host', $this->host . ':' . $this->port);
		}

		if (isset($u['user']) && $u['user'] != '') {
			$this->setCredentials(urldecode($u['user']), isset($u['pass']) ? urldecode($u['pass']) : '');
		}
	}

	/**
	* gets the I/O method to use
	*
	* @return	string	I/O method to use (socket|curl|unknown)
	* @access	private
	*/
	public function io_method()
	{
		if ($this->use_curl || $this->scheme == 'https' || $this->scheme == 'http' && $this->authtype == 'ntlm' || $this->scheme == 'http' && is_array($this->proxy) && $this->proxy['authtype'] == 'ntlm') {
			return 'curl';
		}

		if (($this->scheme == 'http' || $this->scheme == 'ssl') && $this->authtype != 'ntlm' && (!is_array($this->proxy) || $this->proxy['authtype'] != 'ntlm')) {
			return 'socket';
		}

		return 'unknown';
	}

	/**
	* establish an HTTP connection
	*
	* @param    integer $timeout set connection timeout in seconds
	* @param	integer $response_timeout set response timeout in seconds
	* @return	boolean true if connected, false if not
	* @access   private
	*/
	public function connect($connection_timeout = 0, $response_timeout = 30)
	{
		$this->debug('connect connection_timeout ' . $connection_timeout . ', response_timeout ' . $response_timeout . ', scheme ' . $this->scheme . ', host ' . $this->host . ', port ' . $this->port);

		if ($this->io_method() == 'socket') {
			if (!is_array($this->proxy)) {
				$host = $this->host;
				$port = $this->port;
			}
			else {
				$host = $this->proxy['host'];
				$port = $this->proxy['port'];
			}

			if ($this->persistentConnection && isset($this->fp) && is_resource($this->fp)) {
				if (!feof($this->fp)) {
					$this->debug('Re-use persistent connection');
					return true;
				}

				fclose($this->fp);
				$this->debug('Closed persistent connection at EOF');
			}

			if ($this->scheme == 'ssl') {
				$host = 'ssl://' . $host;
			}

			$this->debug('calling fsockopen with host ' . $host . ' connection_timeout ' . $connection_timeout);

			if (0 < $connection_timeout) {
				$this->fp = @fsockopen($host, $this->port, $this->errno, $this->error_str, $connection_timeout);
			}
			else {
				$this->fp = @fsockopen($host, $this->port, $this->errno, $this->error_str);
			}

			if (!$this->fp) {
				$msg = 'Couldn\'t open socket connection to server ' . $this->url;

				if ($this->errno) {
					$msg .= ', Error (' . $this->errno . '): ' . $this->error_str;
				}
				else {
					$msg .= ' prior to connect().  This is often a problem looking up the host name.';
				}

				$this->debug($msg);
				$this->setError($msg);
				return false;
			}

			$this->debug('set response timeout to ' . $response_timeout);
			socket_set_timeout($this->fp, $response_timeout);
			$this->debug('socket connected');
			return true;
		}

		if ($this->io_method() == 'curl') {
			if (!extension_loaded('curl')) {
				$this->setError('The PHP cURL Extension is required for HTTPS or NLTM.  You will need to re-build or update your PHP to include cURL or change php.ini to load the PHP cURL extension.');
				return false;
			}

			if (defined('CURLOPT_CONNECTIONTIMEOUT')) {
				$CURLOPT_CONNECTIONTIMEOUT = CURLOPT_CONNECTIONTIMEOUT;
			}
			else {
				$CURLOPT_CONNECTIONTIMEOUT = 78;
			}

			if (defined('CURLOPT_HTTPAUTH')) {
				$CURLOPT_HTTPAUTH = CURLOPT_HTTPAUTH;
			}
			else {
				$CURLOPT_HTTPAUTH = 107;
			}

			if (defined('CURLOPT_PROXYAUTH')) {
				$CURLOPT_PROXYAUTH = CURLOPT_PROXYAUTH;
			}
			else {
				$CURLOPT_PROXYAUTH = 111;
			}

			if (defined('CURLAUTH_BASIC')) {
				$CURLAUTH_BASIC = CURLAUTH_BASIC;
			}
			else {
				$CURLAUTH_BASIC = 1;
			}

			if (defined('CURLAUTH_DIGEST')) {
				$CURLAUTH_DIGEST = CURLAUTH_DIGEST;
			}
			else {
				$CURLAUTH_DIGEST = 2;
			}

			if (defined('CURLAUTH_NTLM')) {
				$CURLAUTH_NTLM = CURLAUTH_NTLM;
			}
			else {
				$CURLAUTH_NTLM = 8;
			}

			$this->debug('connect using cURL');
			$this->ch = curl_init();
			$hostURL = $this->port != '' ? $this->scheme . '://' . $this->host . ':' . $this->port : $this->scheme . '://' . $this->host;
			$hostURL .= $this->path;
			$this->setCurlOption(CURLOPT_URL, $hostURL);
			if (ini_get('safe_mode') || ini_get('open_basedir')) {
				$this->debug('safe_mode or open_basedir set, so do not set CURLOPT_FOLLOWLOCATION');
				$this->debug('safe_mode = ');
				$this->appendDebug($this->varDump(ini_get('safe_mode')));
				$this->debug('open_basedir = ');
				$this->appendDebug($this->varDump(ini_get('open_basedir')));
			}
			else {
				$this->setCurlOption(CURLOPT_FOLLOWLOCATION, 1);
			}

			$this->setCurlOption(CURLOPT_HEADER, 1);
			$this->setCurlOption(CURLOPT_RETURNTRANSFER, 1);

			if ($this->persistentConnection) {
				$this->persistentConnection = false;
				$this->setHeader('Connection', 'close');
			}

			if ($connection_timeout != 0) {
				$this->setCurlOption($CURLOPT_CONNECTIONTIMEOUT, $connection_timeout);
			}

			if ($response_timeout != 0) {
				$this->setCurlOption(CURLOPT_TIMEOUT, $response_timeout);
			}

			if ($this->scheme == 'https') {
				$this->debug('set cURL SSL verify options');
				$this->setCurlOption(CURLOPT_SSL_VERIFYPEER, 0);
				$this->setCurlOption(CURLOPT_SSL_VERIFYHOST, 0);

				if ($this->authtype == 'certificate') {
					$this->debug('set cURL certificate options');

					if (isset($this->certRequest['cainfofile'])) {
						$this->setCurlOption(CURLOPT_CAINFO, $this->certRequest['cainfofile']);
					}

					if (isset($this->certRequest['verifypeer'])) {
						$this->setCurlOption(CURLOPT_SSL_VERIFYPEER, $this->certRequest['verifypeer']);
					}
					else {
						$this->setCurlOption(CURLOPT_SSL_VERIFYPEER, 1);
					}

					if (isset($this->certRequest['verifyhost'])) {
						$this->setCurlOption(CURLOPT_SSL_VERIFYHOST, $this->certRequest['verifyhost']);
					}
					else {
						$this->setCurlOption(CURLOPT_SSL_VERIFYHOST, 1);
					}

					if (isset($this->certRequest['sslcertfile'])) {
						$this->setCurlOption(CURLOPT_SSLCERT, $this->certRequest['sslcertfile']);
					}

					if (isset($this->certRequest['sslkeyfile'])) {
						$this->setCurlOption(CURLOPT_SSLKEY, $this->certRequest['sslkeyfile']);
					}

					if (isset($this->certRequest['passphrase'])) {
						$this->setCurlOption(CURLOPT_SSLKEYPASSWD, $this->certRequest['passphrase']);
					}

					if (isset($this->certRequest['certpassword'])) {
						$this->setCurlOption(CURLOPT_SSLCERTPASSWD, $this->certRequest['certpassword']);
					}
				}
			}

			if ($this->authtype && $this->authtype != 'certificate') {
				if ($this->username) {
					$this->debug('set cURL username/password');
					$this->setCurlOption(CURLOPT_USERPWD, $this->username . ':' . $this->password);
				}

				if ($this->authtype == 'basic') {
					$this->debug('set cURL for Basic authentication');
					$this->setCurlOption($CURLOPT_HTTPAUTH, $CURLAUTH_BASIC);
				}

				if ($this->authtype == 'digest') {
					$this->debug('set cURL for digest authentication');
					$this->setCurlOption($CURLOPT_HTTPAUTH, $CURLAUTH_DIGEST);
				}

				if ($this->authtype == 'ntlm') {
					$this->debug('set cURL for NTLM authentication');
					$this->setCurlOption($CURLOPT_HTTPAUTH, $CURLAUTH_NTLM);
				}
			}

			if (is_array($this->proxy)) {
				$this->debug('set cURL proxy options');

				if ($this->proxy['port'] != '') {
					$this->setCurlOption(CURLOPT_PROXY, $this->proxy['host'] . ':' . $this->proxy['port']);
				}
				else {
					$this->setCurlOption(CURLOPT_PROXY, $this->proxy['host']);
				}

				if ($this->proxy['username'] || $this->proxy['password']) {
					$this->debug('set cURL proxy authentication options');
					$this->setCurlOption(CURLOPT_PROXYUSERPWD, $this->proxy['username'] . ':' . $this->proxy['password']);

					if ($this->proxy['authtype'] == 'basic') {
						$this->setCurlOption($CURLOPT_PROXYAUTH, $CURLAUTH_BASIC);
					}

					if ($this->proxy['authtype'] == 'ntlm') {
						$this->setCurlOption($CURLOPT_PROXYAUTH, $CURLAUTH_NTLM);
					}
				}
			}

			$this->debug('cURL connection set up');
			return true;
		}

		$this->setError('Unknown scheme ' . $this->scheme);
		$this->debug('Unknown scheme ' . $this->scheme);
		return false;
	}

	/**
	* sends the SOAP request and gets the SOAP response via HTTP[S]
	*
	* @param    string $data message data
	* @param    integer $timeout set connection timeout in seconds
	* @param	integer $response_timeout set response timeout in seconds
	* @param	array $cookies cookies to send
	* @return	string data
	* @access   public
	*/
	public function send($data, $timeout = 0, $response_timeout = 30, $cookies = NULL)
	{
		$this->debug('entered send() with data of length: ' . strlen($data));
		$this->tryagain = true;
		$tries = 0;

		while ($this->tryagain) {
			$this->tryagain = false;

			if ($tries++ < 2) {
				if (!$this->connect($timeout, $response_timeout)) {
					return false;
				}

				if (!$this->sendRequest($data, $cookies)) {
					return false;
				}

				$respdata = $this->getResponse();
			}
			else {
				$this->setError('Too many tries to get an OK response (' . $this->response_status_line . ')');
			}
		}

		$this->debug('end of send()');
		return $respdata;
	}

	/**
	* sends the SOAP request and gets the SOAP response via HTTPS using CURL
	*
	* @param    string $data message data
	* @param    integer $timeout set connection timeout in seconds
	* @param	integer $response_timeout set response timeout in seconds
	* @param	array $cookies cookies to send
	* @return	string data
	* @access   public
	* @deprecated
	*/
	public function sendHTTPS($data, $timeout = 0, $response_timeout = 30, $cookies)
	{
		return $this->send($data, $timeout, $response_timeout, $cookies);
	}

	/**
	* if authenticating, set user credentials here
	*
	* @param    string $username
	* @param    string $password
	* @param	string $authtype (basic|digest|certificate|ntlm)
	* @param	array $digestRequest (keys must be nonce, nc, realm, qop)
	* @param	array $certRequest (keys must be cainfofile (optional), sslcertfile, sslkeyfile, passphrase, certpassword (optional), verifypeer (optional), verifyhost (optional): see corresponding options in cURL docs)
	* @access   public
	*/
	public function setCredentials($username, $password, $authtype = 'basic', $digestRequest = array(), $certRequest = array())
	{
		$this->debug('setCredentials username=' . $username . ' authtype=' . $authtype . ' digestRequest=');
		$this->appendDebug($this->varDump($digestRequest));
		$this->debug('certRequest=');
		$this->appendDebug($this->varDump($certRequest));

		if ($authtype == 'basic') {
			$this->setHeader('Authorization', 'Basic ' . base64_encode(str_replace(':', '', $username) . ':' . $password));
		}
		else if ($authtype == 'digest') {
			if (isset($digestRequest['nonce'])) {
				$digestRequest['nc'] = isset($digestRequest['nc']) ? $digestRequest['nc']++ : 1;
				$A1 = $username . ':' . (isset($digestRequest['realm']) ? $digestRequest['realm'] : '') . ':' . $password;
				$HA1 = md5($A1);
				$A2 = $this->request_method . ':' . $this->digest_uri;
				$HA2 = md5($A2);
				$unhashedDigest = '';
				$nonce = isset($digestRequest['nonce']) ? $digestRequest['nonce'] : '';
				$cnonce = $nonce;

				if ($digestRequest['qop'] != '') {
					$unhashedDigest = $HA1 . ':' . $nonce . ':' . sprintf('%08d', $digestRequest['nc']) . ':' . $cnonce . ':' . $digestRequest['qop'] . ':' . $HA2;
				}
				else {
					$unhashedDigest = $HA1 . ':' . $nonce . ':' . $HA2;
				}

				$hashedDigest = md5($unhashedDigest);
				$opaque = '';

				if (isset($digestRequest['opaque'])) {
					$opaque = ', opaque="' . $digestRequest['opaque'] . '"';
				}

				$this->setHeader('Authorization', 'Digest username="' . $username . '", realm="' . $digestRequest['realm'] . '", nonce="' . $nonce . '", uri="' . $this->digest_uri . $opaque . '", cnonce="' . $cnonce . '", nc=' . sprintf('%08x', $digestRequest['nc']) . ', qop="' . $digestRequest['qop'] . '", response="' . $hashedDigest . '"');
			}
		}
		else if ($authtype == 'certificate') {
			$this->certRequest = $certRequest;
			$this->debug('Authorization header not set for certificate');
		}
		else {
			if ($authtype == 'ntlm') {
				$this->debug('Authorization header not set for ntlm');
			}
		}

		$this->username = $username;
		$this->password = $password;
		$this->authtype = $authtype;
		$this->digestRequest = $digestRequest;
	}

	/**
	* set the soapaction value
	*
	* @param    string $soapaction
	* @access   public
	*/
	public function setSOAPAction($soapaction)
	{
		$this->setHeader('SOAPAction', '"' . $soapaction . '"');
	}

	/**
	* use http encoding
	*
	* @param    string $enc encoding style. supported values: gzip, deflate, or both
	* @access   public
	*/
	public function setEncoding($enc = 'gzip, deflate')
	{
		if (function_exists('gzdeflate')) {
			$this->protocol_version = '1.1';
			$this->setHeader('Accept-Encoding', $enc);

			if (!isset($this->outgoing_headers['Connection'])) {
				$this->setHeader('Connection', 'close');
				$this->persistentConnection = false;
			}

			$this->encoding = $enc;
		}
	}

	/**
	* set proxy info here
	*
	* @param    string $proxyhost use an empty string to remove proxy
	* @param    string $proxyport
	* @param	string $proxyusername
	* @param	string $proxypassword
	* @param	string $proxyauthtype (basic|ntlm)
	* @access   public
	*/
	public function setProxy($proxyhost, $proxyport, $proxyusername = '', $proxypassword = '', $proxyauthtype = 'basic')
	{
		if ($proxyhost) {
			$this->proxy = array('host' => $proxyhost, 'port' => $proxyport, 'username' => $proxyusername, 'password' => $proxypassword, 'authtype' => $proxyauthtype);
			if ($proxyusername != '' && $proxypassword != '' && ($proxyauthtype = 'basic')) {
				$this->setHeader('Proxy-Authorization', ' Basic ' . base64_encode($proxyusername . ':' . $proxypassword));
				return NULL;
			}
		}
		else {
			$this->debug('remove proxy');
			$proxy = NULL;
			unsetHeader('Proxy-Authorization');
		}
	}

	/**
	 * Test if the given string starts with a header that is to be skipped.
	 * Skippable headers result from chunked transfer and proxy requests.
	 *
	 * @param	string $data The string to check.
	 * @returns	boolean	Whether a skippable header was found.
	 * @access	private
	 */
	public function isSkippableCurlHeader(&$data)
	{
		$skipHeaders = array('HTTP/1.1 100', 'HTTP/1.0 301', 'HTTP/1.1 301', 'HTTP/1.0 302', 'HTTP/1.1 302', 'HTTP/1.0 401', 'HTTP/1.1 401', 'HTTP/1.0 200 Connection established');

		foreach ($skipHeaders as $hd) {
			$prefix = substr($data, 0, strlen($hd));

			if ($prefix == $hd) {
				return true;
			}
		}

		return false;
	}

	/**
	* decode a string that is encoded w/ "chunked' transfer encoding
 	* as defined in RFC2068 19.4.6
	*
	* @param    string $buffer
	* @param    string $lb
	* @returns	string
	* @access   public
	* @deprecated
	*/
	public function decodeChunked($buffer, $lb)
	{
		$length = 0;
		$new = '';
		$chunkend = strpos($buffer, $lb);

		if ($chunkend == false) {
			$this->debug('no linebreak found in decodeChunked');
			return $new;
		}

		$temp = substr($buffer, 0, $chunkend);
		$chunk_size = hexdec(trim($temp));
		$chunkstart = $chunkend + strlen($lb);

		while (0 < $chunk_size) {
			$this->debug('chunkstart: ' . $chunkstart . ' chunk_size: ' . $chunk_size);
			$chunkend = strpos($buffer, $lb, $chunkstart + $chunk_size);

			if ($chunkend == false) {
				$chunk = substr($buffer, $chunkstart);
				$new .= $chunk;
				$length += strlen($chunk);
				break;
			}

			$chunk = substr($buffer, $chunkstart, $chunkend - $chunkstart);
			$new .= $chunk;
			$length += strlen($chunk);
			$chunkstart = $chunkend + strlen($lb);
			$chunkend = strpos($buffer, $lb, $chunkstart) + strlen($lb);

			if ($chunkend == false) {
				break;
			}

			$temp = substr($buffer, $chunkstart, $chunkend - $chunkstart);
			$chunk_size = hexdec(trim($temp));
			$chunkstart = $chunkend;
		}

		return $new;
	}

	/**
	 * Writes the payload, including HTTP headers, to $this->outgoing_payload.
	 *
	 * @param	string $data HTTP body
	 * @param	string $cookie_str data for HTTP Cookie header
	 * @return	void
	 * @access	private
	 */
	public function buildPayload($data, $cookie_str = '')
	{
		if ($this->request_method != 'GET') {
			$this->setHeader('Content-Length', strlen($data));
		}

		if ($this->proxy) {
			$uri = $this->url;
		}
		else {
			$uri = $this->uri;
		}

		$req = $this->request_method . ' ' . $uri . ' HTTP/' . $this->protocol_version;
		$this->debug('HTTP request: ' . $req);
		$this->outgoing_payload = $req . "\r\n";

		foreach ($this->outgoing_headers as $k => $v) {
			$hdr = $k . ': ' . $v;
			$this->debug('HTTP header: ' . $hdr);
			$this->outgoing_payload .= $hdr . "\r\n";
		}

		if ($cookie_str != '') {
			$hdr = 'Cookie: ' . $cookie_str;
			$this->debug('HTTP header: ' . $hdr);
			$this->outgoing_payload .= $hdr . "\r\n";
		}

		$this->outgoing_payload .= "\r\n";
		$this->outgoing_payload .= $data;
	}

	/**
	* sends the SOAP request via HTTP[S]
	*
	* @param    string $data message data
	* @param	array $cookies cookies to send
	* @return	boolean	true if OK, false if problem
	* @access   private
	*/
	public function sendRequest($data, $cookies = NULL)
	{
		$cookie_str = $this->getCookiesForRequest($cookies, $this->scheme == 'ssl' || $this->scheme == 'https');
		$this->buildPayload($data, $cookie_str);

		if ($this->io_method() == 'socket') {
			if (!fputs($this->fp, $this->outgoing_payload, strlen($this->outgoing_payload))) {
				$this->setError('couldn\'t write message data to socket');
				$this->debug('couldn\'t write message data to socket');
				return false;
			}

			$this->debug('wrote data to socket, length = ' . strlen($this->outgoing_payload));
			return true;
		}

		if ($this->io_method() == 'curl') {
			$curl_headers = array();

			foreach ($this->outgoing_headers as $k => $v) {
				if ($k == 'Connection' || $k == 'Content-Length' || $k == 'Host' || $k == 'Authorization' || $k == 'Proxy-Authorization') {
					$this->debug('Skip cURL header ' . $k . ': ' . $v);
				}
				else {
					$curl_headers[] = $k . ': ' . $v;
				}
			}

			if ($cookie_str != '') {
				$curl_headers[] = 'Cookie: ' . $cookie_str;
			}

			$this->setCurlOption(CURLOPT_HTTPHEADER, $curl_headers);
			$this->debug('set cURL HTTP headers');

			if ($this->request_method == 'POST') {
				$this->setCurlOption(CURLOPT_POST, 1);
				$this->setCurlOption(CURLOPT_POSTFIELDS, $data);
				$this->debug('set cURL POST data');
			}

			foreach ($this->ch_options as $key => $val) {
				$this->setCurlOption($key, $val);
			}

			$this->debug('set cURL payload');
			return true;
		}
	}

	/**
	* gets the SOAP response via HTTP[S]
	*
	* @return	string the response (also sets member variables like incoming_payload)
	* @access   private
	*/
	public function getResponse()
	{
		$this->incoming_payload = '';

		if ($this->io_method() == 'socket') {
			$data = '';

			while (!isset($lb)) {
				if (feof($this->fp)) {
					$this->incoming_payload = $data;
					$this->debug('found no headers before EOF after length ' . strlen($data));
					$this->debug("received before EOF:\n" . $data);
					$this->setError('server failed to send headers');
					return false;
				}

				$tmp = fgets($this->fp, 256);
				$tmplen = strlen($tmp);
				$this->debug('read line of ' . $tmplen . ' bytes: ' . trim($tmp));

				if ($tmplen == 0) {
					$this->incoming_payload = $data;
					$this->debug('socket read of headers timed out after length ' . strlen($data));
					$this->debug('read before timeout: ' . $data);
					$this->setError('socket read of headers timed out');
					return false;
				}

				$data .= $tmp;
				$pos = strpos($data, "\r\n\r\n");

				if (1 < $pos) {
					$lb = "\r\n";
				}
				else {
					$pos = strpos($data, "\n\n");

					if (1 < $pos) {
						$lb = "\n";
					}
				}

				if (isset($lb) && preg_match('/^HTTP\\/1.1 100/', $data)) {
					unset($lb);
					$data = '';
				}
			}

			$this->incoming_payload .= $data;
			$this->debug('found end of headers after length ' . strlen($data));
			$header_data = trim(substr($data, 0, $pos));
			$header_array = explode($lb, $header_data);
			$this->incoming_headers = array();
			$this->incoming_cookies = array();

			foreach ($header_array as $header_line) {
				$arr = explode(':', $header_line, 2);

				if (1 < count($arr)) {
					$header_name = strtolower(trim($arr[0]));
					$this->incoming_headers[$header_name] = trim($arr[1]);

					if ($header_name == 'set-cookie') {
						$cookie = $this->parseCookie(trim($arr[1]));

						if ($cookie) {
							$this->incoming_cookies[] = $cookie;
							$this->debug('found cookie: ' . $cookie['name'] . ' = ' . $cookie['value']);
						}
						else {
							$this->debug('did not find cookie in ' . trim($arr[1]));
						}
					}
				}
				else {
					if (isset($header_name)) {
						$this->incoming_headers[$header_name] .= $lb . ' ' . $header_line;
					}
				}
			}

			if (isset($this->incoming_headers['transfer-encoding']) && strtolower($this->incoming_headers['transfer-encoding']) == 'chunked') {
				$content_length = 2147483647;
				$chunked = true;
				$this->debug('want to read chunked content');
			}
			else if (isset($this->incoming_headers['content-length'])) {
				$content_length = $this->incoming_headers['content-length'];
				$chunked = false;
				$this->debug('want to read content of length ' . $content_length);
			}
			else {
				$content_length = 2147483647;
				$chunked = false;
				$this->debug('want to read content to EOF');
			}

			$data = '';

			do {
				if ($chunked) {
					$tmp = fgets($this->fp, 256);
					$tmplen = strlen($tmp);
					$this->debug('read chunk line of ' . $tmplen . ' bytes');

					if ($tmplen == 0) {
						$this->incoming_payload = $data;
						$this->debug('socket read of chunk length timed out after length ' . strlen($data));
						$this->debug("read before timeout:\n" . $data);
						$this->setError('socket read of chunk length timed out');
						return false;
					}

					$content_length = hexdec(trim($tmp));
					$this->debug('chunk length ' . $content_length);
				}

				$strlen = 0;

				while ($strlen < $content_length && !feof($this->fp)) {
					$readlen = min(8192, $content_length - $strlen);
					$tmp = fread($this->fp, $readlen);
					$tmplen = strlen($tmp);
					$this->debug('read buffer of ' . $tmplen . ' bytes');
					if ($tmplen == 0 && !feof($this->fp)) {
						$this->incoming_payload = $data;
						$this->debug('socket read of body timed out after length ' . strlen($data));
						$this->debug("read before timeout:\n" . $data);
						$this->setError('socket read of body timed out');
						return false;
					}

					$strlen += $tmplen;
					$data .= $tmp;
				}

				if ($chunked && 0 < $content_length) {
					$tmp = fgets($this->fp, 256);
					$tmplen = strlen($tmp);
					$this->debug('read chunk terminator of ' . $tmplen . ' bytes');

					if ($tmplen == 0) {
						$this->incoming_payload = $data;
						$this->debug('socket read of chunk terminator timed out after length ' . strlen($data));
						$this->debug("read before timeout:\n" . $data);
						$this->setError('socket read of chunk terminator timed out');
						return false;
					}
				}

			} while ($chunked && 0 < $content_length && !feof($this->fp));

			if (feof($this->fp)) {
				$this->debug('read to EOF');
			}

			$this->debug('read body of length ' . strlen($data));
			$this->incoming_payload .= $data;
			$this->debug('received a total of ' . strlen($this->incoming_payload) . ' bytes of data from server');
			if (isset($this->incoming_headers['connection']) && strtolower($this->incoming_headers['connection']) == 'close' || !$this->persistentConnection || feof($this->fp)) {
				fclose($this->fp);
				$this->fp = false;
				$this->debug('closed socket');
			}

			if ($this->incoming_payload == '') {
				$this->setError('no response from server');
				return false;
			}
		}
		else {
			if ($this->io_method() == 'curl') {
				$this->debug('send and receive with cURL');
				$this->incoming_payload = curl_exec($this->ch);
				$data = $this->incoming_payload;
				$cErr = curl_error($this->ch);

				if ($cErr != '') {
					$err = 'cURL ERROR: ' . curl_errno($this->ch) . ': ' . $cErr . '<br>';

					foreach (curl_getinfo($this->ch) as $k => $v) {
						$err .= $k . ': ' . $v . '<br>';
					}

					$this->debug($err);
					$this->setError($err);
					curl_close($this->ch);
					return false;
				}

				$this->debug('No cURL error, closing cURL');
				curl_close($this->ch);
				$savedata = $data;

				while ($this->isSkippableCurlHeader($data)) {
					$this->debug('Found HTTP header to skip');

					if ($pos = strpos($data, "\r\n\r\n")) {
						$data = ltrim(substr($data, $pos));
					}
					else {
						if ($pos = strpos($data, "\n\n")) {
							$data = ltrim(substr($data, $pos));
						}
					}
				}

				if ($data == '') {
					$data = $savedata;

					while (preg_match('/^HTTP\\/1.1 100/', $data)) {
						if ($pos = strpos($data, "\r\n\r\n")) {
							$data = ltrim(substr($data, $pos));
						}
						else {
							if ($pos = strpos($data, "\n\n")) {
								$data = ltrim(substr($data, $pos));
							}
						}
					}
				}

				if ($pos = strpos($data, "\r\n\r\n")) {
					$lb = "\r\n";
				}
				else if ($pos = strpos($data, "\n\n")) {
					$lb = "\n";
				}
				else {
					$this->debug('no proper separation of headers and document');
					$this->setError('no proper separation of headers and document');
					return false;
				}

				$header_data = trim(substr($data, 0, $pos));
				$header_array = explode($lb, $header_data);
				$data = ltrim(substr($data, $pos));
				$this->debug('found proper separation of headers and document');
				$this->debug('cleaned data, stringlen: ' . strlen($data));

				foreach ($header_array as $header_line) {
					$arr = explode(':', $header_line, 2);

					if (1 < count($arr)) {
						$header_name = strtolower(trim($arr[0]));
						$this->incoming_headers[$header_name] = trim($arr[1]);

						if ($header_name == 'set-cookie') {
							$cookie = $this->parseCookie(trim($arr[1]));

							if ($cookie) {
								$this->incoming_cookies[] = $cookie;
								$this->debug('found cookie: ' . $cookie['name'] . ' = ' . $cookie['value']);
							}
							else {
								$this->debug('did not find cookie in ' . trim($arr[1]));
							}
						}
					}
					else {
						if (isset($header_name)) {
							$this->incoming_headers[$header_name] .= $lb . ' ' . $header_line;
						}
					}
				}
			}
		}

		$this->response_status_line = $header_array[0];
		$arr = explode(' ', $this->response_status_line, 3);
		$http_version = $arr[0];
		$http_status = intval($arr[1]);
		$http_reason = 2 < count($arr) ? $arr[2] : '';
		if (isset($this->incoming_headers['location']) && ($http_status == 301 || $http_status == 302)) {
			$this->debug('Got ' . $http_status . ' ' . $http_reason . ' with Location: ' . $this->incoming_headers['location']);
			$this->setURL($this->incoming_headers['location']);
			$this->tryagain = true;
			return false;
		}

		if (isset($this->incoming_headers['www-authenticate']) && $http_status == 401) {
			$this->debug('Got 401 ' . $http_reason . ' with WWW-Authenticate: ' . $this->incoming_headers['www-authenticate']);

			if (strstr($this->incoming_headers['www-authenticate'], 'Digest ')) {
				$this->debug('Server wants digest authentication');
				$digestString = str_replace('Digest ', '', $this->incoming_headers['www-authenticate']);
				$digestElements = explode(',', $digestString);

				foreach ($digestElements as $val) {
					$tempElement = explode('=', trim($val), 2);
					$digestRequest[$tempElement[0]] = str_replace('"', '', $tempElement[1]);
				}

				if (isset($digestRequest['nonce'])) {
					$this->setCredentials($this->username, $this->password, 'digest', $digestRequest);
					$this->tryagain = true;
					return false;
				}
			}

			$this->debug('HTTP authentication failed');
			$this->setError('HTTP authentication failed');
			return false;
		}

		if (300 <= $http_status && $http_status <= 307 || 400 <= $http_status && $http_status <= 417 || 501 <= $http_status && $http_status <= 505) {
			$this->setError('Unsupported HTTP response status ' . $http_status . ' ' . $http_reason . ' (soapclient->response has contents of the response)');
			return false;
		}

		if (isset($this->incoming_headers['content-encoding']) && $this->incoming_headers['content-encoding'] != '') {
			if (strtolower($this->incoming_headers['content-encoding']) == 'deflate' || strtolower($this->incoming_headers['content-encoding']) == 'gzip') {
				if (function_exists('gzinflate')) {
					$this->debug('The gzinflate function exists');
					$datalen = strlen($data);

					if ($this->incoming_headers['content-encoding'] == 'deflate') {
						if ($degzdata = @gzinflate($data)) {
							$data = $degzdata;
							$this->debug('The payload has been inflated to ' . strlen($data) . ' bytes');

							if (strlen($data) < $datalen) {
								$this->debug('The inflated payload is smaller than the gzipped one; try again');

								if ($degzdata = @gzinflate($data)) {
									$data = $degzdata;
									$this->debug('The payload has been inflated again to ' . strlen($data) . ' bytes');
								}
							}
						}
						else {
							$this->debug('Error using gzinflate to inflate the payload');
							$this->setError('Error using gzinflate to inflate the payload');
						}
					}
					else {
						if ($this->incoming_headers['content-encoding'] == 'gzip') {
							if ($degzdata = @gzinflate(substr($data, 10))) {
								$data = $degzdata;
								$this->debug('The payload has been un-gzipped to ' . strlen($data) . ' bytes');

								if (strlen($data) < $datalen) {
									$this->debug('The un-gzipped payload is smaller than the gzipped one; try again');

									if ($degzdata = @gzinflate(substr($data, 10))) {
										$data = $degzdata;
										$this->debug('The payload has been un-gzipped again to ' . strlen($data) . ' bytes');
									}
								}
							}
							else {
								$this->debug('Error using gzinflate to un-gzip the payload');
								$this->setError('Error using gzinflate to un-gzip the payload');
							}
						}
					}

					$this->incoming_payload = $header_data . $lb . $lb . $data;
				}
				else {
					$this->debug('The server sent compressed data. Your php install must have the Zlib extension compiled in to support this.');
					$this->setError('The server sent compressed data. Your php install must have the Zlib extension compiled in to support this.');
				}
			}
			else {
				$this->debug('Unsupported Content-Encoding ' . $this->incoming_headers['content-encoding']);
				$this->setError('Unsupported Content-Encoding ' . $this->incoming_headers['content-encoding']);
			}
		}
		else {
			$this->debug('No Content-Encoding header');
		}

		if (strlen($data) == 0) {
			$this->debug('no data after headers!');
			$this->setError('no data present after HTTP headers');
			return false;
		}

		return $data;
	}

	/**
	 * sets the content-type for the SOAP message to be sent
	 *
	 * @param	string $type the content type, MIME style
	 * @param	mixed $charset character set used for encoding (or false)
	 * @access	public
	 */
	public function setContentType($type, $charset = false)
	{
		$this->setHeader('Content-Type', $type . ($charset ? '; charset=' . $charset : ''));
	}

	/**
	 * specifies that an HTTP persistent connection should be used
	 *
	 * @return	boolean whether the request was honored by this method.
	 * @access	public
	 */
	public function usePersistentConnection()
	{
		if (isset($this->outgoing_headers['Accept-Encoding'])) {
			return false;
		}

		$this->protocol_version = '1.1';
		$this->persistentConnection = true;
		$this->setHeader('Connection', 'Keep-Alive');
		return true;
	}

	/**
	 * parse an incoming Cookie into it's parts
	 *
	 * @param	string $cookie_str content of cookie
	 * @return	array with data of that cookie
	 * @access	private
	 */
	public function parseCookie($cookie_str)
	{
		$cookie_str = str_replace('; ', ';', $cookie_str) . ';';
		$data = preg_split('/;/', $cookie_str);
		$value_str = $data[0];
		$cookie_param = 'domain=';
		$start = strpos($cookie_str, $cookie_param);

		if (0 < $start) {
			$domain = substr($cookie_str, $start + strlen($cookie_param));
			$domain = substr($domain, 0, strpos($domain, ';'));
		}
		else {
			$domain = '';
		}

		$cookie_param = 'expires=';
		$start = strpos($cookie_str, $cookie_param);

		if (0 < $start) {
			$expires = substr($cookie_str, $start + strlen($cookie_param));
			$expires = substr($expires, 0, strpos($expires, ';'));
		}
		else {
			$expires = '';
		}

		$cookie_param = 'path=';
		$start = strpos($cookie_str, $cookie_param);

		if (0 < $start) {
			$path = substr($cookie_str, $start + strlen($cookie_param));
			$path = substr($path, 0, strpos($path, ';'));
		}
		else {
			$path = '/';
		}

		$cookie_param = ';secure;';

		if (strpos($cookie_str, $cookie_param) !== false) {
			$secure = true;
		}
		else {
			$secure = false;
		}

		$sep_pos = strpos($value_str, '=');

		if ($sep_pos) {
			$name = substr($value_str, 0, $sep_pos);
			$value = substr($value_str, $sep_pos + 1);
			$cookie = array('name' => $name, 'value' => $value, 'domain' => $domain, 'path' => $path, 'expires' => $expires, 'secure' => $secure);
			return $cookie;
		}

		return false;
	}

	/**
	 * sort out cookies for the current request
	 *
	 * @param	array $cookies array with all cookies
	 * @param	boolean $secure is the send-content secure or not?
	 * @return	string for Cookie-HTTP-Header
	 * @access	private
	 */
	public function getCookiesForRequest($cookies, $secure = false)
	{
		$cookie_str = '';
		if (!is_null($cookies) && is_array($cookies)) {
			foreach ($cookies as $cookie) {
				if (!is_array($cookie)) {
					continue;
				}

				$this->debug('check cookie for validity: ' . $cookie['name'] . '=' . $cookie['value']);
				if (isset($cookie['expires']) && !empty($cookie['expires'])) {
					if (strtotime($cookie['expires']) <= time()) {
						$this->debug('cookie has expired');
						continue;
					}
				}

				if (isset($cookie['domain']) && !empty($cookie['domain'])) {
					$domain = preg_quote($cookie['domain']);

					if (!preg_match('\'.*' . $domain . '$\'i', $this->host)) {
						$this->debug('cookie has different domain');
						continue;
					}
				}

				if (isset($cookie['path']) && !empty($cookie['path'])) {
					$path = preg_quote($cookie['path']);

					if (!preg_match('\'^' . $path . '.*\'i', $this->path)) {
						$this->debug('cookie is for a different path');
						continue;
					}
				}

				if (!$secure && isset($cookie['secure']) && $cookie['secure']) {
					$this->debug('cookie is secure, transport is not');
					continue;
				}

				$cookie_str .= $cookie['name'] . '=' . $cookie['value'] . '; ';
				$this->debug('add cookie to Cookie-String: ' . $cookie['name'] . '=' . $cookie['value']);
			}
		}

		return $cookie_str;
	}

	/**
	* constructor
	*
	* @access	public
	*/
	public function nusoap_base()
	{
		$this->debugLevel = $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* gets the global debug level, which applies to future instances
	*
	* @return	integer	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getGlobalDebugLevel()
	{
		return $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* sets the global debug level, which applies to future instances
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setGlobalDebugLevel($level)
	{
		$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = $level;
	}

	/**
	* gets the debug level for this instance
	*
	* @return	int	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}

	/**
	* sets the debug level for this instance
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}

	/**
	* adds debug data to the instance debug string with formatting
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function debug($string)
	{
		if (0 < $this->debugLevel) {
			$this->appendDebug($this->getmicrotime() . ' ' . get_class($this) . (': ' . $string . "\n"));
		}
	}

	/**
	* adds debug data to the instance debug string without formatting
	*
	* @param    string $string debug data
	* @access   public
	*/
	public function appendDebug($string)
	{
		if (0 < $this->debugLevel) {
			$this->debug_str .= $string;
		}
	}

	/**
	* clears the current debug data for this instance
	*
	* @access   public
	*/
	public function clearDebug()
	{
		$this->debug_str = '';
	}

	/**
	* gets the current debug data for this instance
	*
	* @return   debug data
	* @access   public
	*/
	public function& getDebug()
	{
		return $this->debug_str;
	}

	/**
	* gets the current debug data for this instance as an XML comment
	* this may change the contents of the debug data
	*
	* @return   debug data as an XML comment
	* @access   public
	*/
	public function& getDebugAsXMLComment()
	{
		while (strpos($this->debug_str, '--')) {
			$this->debug_str = str_replace('--', '- -', $this->debug_str);
		}

		$ret = "<!--\n" . $this->debug_str . "\n-->";
		return $ret;
	}

	/**
	* expands entities, e.g. changes '<' to '&lt;'.
	*
	* @param	string	$val	The string in which to expand entities.
	* @access	private
	*/
	public function expandEntities($val)
	{
		if ($this->charencoding) {
			$val = str_replace('&', '&amp;', $val);
			$val = str_replace('\'', '&apos;', $val);
			$val = str_replace('"', '&quot;', $val);
			$val = str_replace('<', '&lt;', $val);
			$val = str_replace('>', '&gt;', $val);
		}

		return $val;
	}

	/**
	* returns error string if present
	*
	* @return   mixed error string or false
	* @access   public
	*/
	public function getError()
	{
		if ($this->error_str != '') {
			return $this->error_str;
		}

		return false;
	}

	/**
	* sets error string
	*
	* @return   boolean $string error string
	* @access   private
	*/
	public function setError($str)
	{
		$this->error_str = $str;
	}

	/**
	* detect if array is a simple array or a struct (associative array)
	*
	* @param	mixed	$val	The PHP array
	* @return	string	(arraySimple|arrayStruct)
	* @access	private
	*/
	public function isArraySimpleOrStruct($val)
	{
		$keyList = array_keys($val);

		foreach ($keyList as $keyListValue) {
			if (!is_int($keyListValue)) {
				return 'arrayStruct';
			}
		}

		return 'arraySimple';
	}

	/**
	* serializes PHP values in accordance w/ section 5. Type information is
	* not serialized if $use == 'literal'.
	*
	* @param	mixed	$val	The value to serialize
	* @param	string	$name	The name (local part) of the XML element
	* @param	string	$type	The XML schema type (local part) for the element
	* @param	string	$name_ns	The namespace for the name of the XML element
	* @param	string	$type_ns	The namespace for the type of the element
	* @param	array	$attributes	The attributes to serialize as name=>value pairs
	* @param	string	$use	The WSDL "use" (encoded|literal)
	* @param	boolean	$soapval	Whether this is called from soapval.
	* @return	string	The serialized element, possibly with child elements
    * @access	public
	*/
	public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = 'encoded', $soapval = false)
	{
		$this->debug('in serialize_val: name=' . $name . ', type=' . $type . ', name_ns=' . $name_ns . ', type_ns=' . $type_ns . ', use=' . $use . ', soapval=' . $soapval);
		$this->appendDebug('value=' . $this->varDump($val));
		$this->appendDebug('attributes=' . $this->varDump($attributes));
		if (is_object($val) && get_class($val) == 'soapval' && !$soapval) {
			$this->debug('serialize_val: serialize soapval');
			$xml = $val->serialize($use);
			$this->appendDebug($val->getDebug());
			$val->clearDebug();
			$this->debug('serialize_val of soapval returning ' . $xml);
			return $xml;
		}

		if (is_numeric($name)) {
			$name = '__numeric_' . $name;
		}
		else {
			if (!$name) {
				$name = 'noname';
			}
		}

		$xmlns = '';

		if ($name_ns) {
			$prefix = 'nu' . rand(1000, 9999);
			$name = $prefix . ':' . $name;
			$xmlns .= ' xmlns:' . $prefix . '="' . $name_ns . '"';
		}

		if ($type_ns != '' && $type_ns == $this->namespaces['xsd']) {
			$type_prefix = 'xsd';
		}
		else {
			if ($type_ns) {
				$type_prefix = 'ns' . rand(1000, 9999);
				$xmlns .= ' xmlns:' . $type_prefix . '="' . $type_ns . '"';
			}
		}

		$atts = '';

		if ($attributes) {
			foreach ($attributes as $k => $v) {
				$atts .= ' ' . $k . '="' . $this->expandEntities($v) . '"';
			}
		}

		if (is_null($val)) {
			$this->debug('serialize_val: serialize null');

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '/>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			$xml = '<' . $name . $xmlns . $type_str . $atts . ' xsi:nil="true"/>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		if ($type != '' && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
			$this->debug('serialize_val: serialize xsd built-in primitive type');

			if (is_bool($val)) {
				if ($type == 'boolean') {
					$val = $val ? 'true' : 'false';
				}
				else {
					if (!$val) {
						$val = 0;
					}
				}
			}
			else {
				if (is_string($val)) {
					$val = $this->expandEntities($val);
				}
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			$xml = '<' . $name . $xmlns . ' xsi:type="xsd:' . $type . '"' . $atts . '>' . $val . '</' . $name . '>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		$xml = '';
		switch (true) {
		case is_bool($val) || $type == 'boolean':
			$this->debug('serialize_val: serialize boolean');

			if ($type == 'boolean') {
				$val = $val ? 'true' : 'false';
			}
			else {
				if (!$val) {
					$val = 0;
				}
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:boolean"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_int($val) || is_long($val) || $type == 'int':
			$this->debug('serialize_val: serialize int');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:int"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_float($val) || is_double($val) || $type == 'float':
			$this->debug('serialize_val: serialize float');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:float"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_string($val) || $type == 'string':
			$this->debug('serialize_val: serialize string');
			$val = $this->expandEntities($val);

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:string"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_object($val):
			$this->debug('serialize_val: serialize object');

			if (get_class($val) == 'soapval') {
				$this->debug('serialize_val: serialize soapval object');
				$pXml = $val->serialize($use);
				$this->appendDebug($val->getDebug());
				$val->clearDebug();
			}
			else {
				if (!$name) {
					$name = get_class($val);
					$this->debug('In serialize_val, used class name ' . $name . ' as element name');
				}
				else {
					$this->debug('In serialize_val, do not override name ' . $name . ' for element name for class ' . get_class($val));
				}

				foreach (get_object_vars($val) as $k => $v) {
					$pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $pXml . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . $type_str . $atts . '>' . $pXml . '</' . $name . '>';
			}

			break;

		case is_array($val) || $type:
			$valueType = $this->isArraySimpleOrStruct($val);
			if ($valueType == 'arraySimple' || preg_match('/^ArrayOf/', $type)) {
				$this->debug('serialize_val: serialize array');
				$i = 0;
				if (is_array($val) && 0 < count($val)) {
					foreach ($val as $v) {
						if (is_object($v) && get_class($v) == 'soapval') {
							$tt_ns = $v->type_ns;
							$tt = $v->type;
						}
						else if (is_array($v)) {
							$tt = $this->isArraySimpleOrStruct($v);
						}
						else {
							$tt = gettype($v);
						}

						$array_types[$tt] = 1;
						$xml .= $this->serialize_val($v, 'item', false, false, false, false, $use);
						++$i;
					}

					if (1 < count($array_types)) {
						$array_typename = 'xsd:anyType';
					}
					else {
						if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
							if ($tt == 'integer') {
								$tt = 'int';
							}

							$array_typename = 'xsd:' . $tt;
						}
						else {
							if (isset($tt) && $tt == 'arraySimple') {
								$array_typename = 'SOAP-ENC:Array';
							}
							else {
								if (isset($tt) && $tt == 'arrayStruct') {
									$array_typename = 'unnamed_struct_use_soapval';
								}
								else {
									if ($tt_ns != '' && $tt_ns == $this->namespaces['xsd']) {
										$array_typename = 'xsd:' . $tt;
									}
									else if ($tt_ns) {
										$tt_prefix = 'ns' . rand(1000, 9999);
										$array_typename = $tt_prefix . ':' . $tt;
										$xmlns .= ' xmlns:' . $tt_prefix . '="' . $tt_ns . '"';
									}
									else {
										$array_typename = $tt;
									}
								}
							}
						}
					}

					$array_type = $i;

					if ($use == 'literal') {
						$type_str = '';
					}
					else {
						if (isset($type) && isset($type_prefix)) {
							$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
						}
						else {
							$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="' . $array_typename . ('[' . $array_type . ']"');
						}
					}
				}
				else if ($use == 'literal') {
					$type_str = '';
				}
				else {
					if (isset($type) && isset($type_prefix)) {
						$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
					}
					else {
						$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="xsd:anyType[0]"';
					}
				}

				$xml = '<' . $name . $xmlns . $type_str . $atts . '>' . $xml . ('</' . $name . '>');
			}
			else {
				$this->debug('serialize_val: serialize struct');
				if (isset($type) && isset($type_prefix)) {
					$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
				}
				else {
					$type_str = '';
				}

				if ($use == 'literal') {
					$xml .= '<' . $name . $xmlns . $atts . '>';
				}
				else {
					$xml .= '<' . $name . $xmlns . $type_str . $atts . '>';
				}

				foreach ($val as $k => $v) {
					if ($type == 'Map' && $type_ns == 'http://xml.apache.org/xml-soap') {
						$xml .= '<item>';
						$xml .= $this->serialize_val($k, 'key', false, false, false, false, $use);
						$xml .= $this->serialize_val($v, 'value', false, false, false, false, $use);
						$xml .= '</item>';
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$xml .= '</' . $name . '>';
			}

			break;

		default:
			$this->debug('serialize_val: serialize unknown');
			$xml .= 'not detected, got ' . gettype($val) . ' for ' . $val;
			break;
		}

		$this->debug('serialize_val returning ' . $xml);
		return $xml;
	}

	/**
    * serializes a message
    *
    * @param string $body the XML of the SOAP body
    * @param mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
    * @param array $namespaces optional the namespaces used in generating the body and headers
    * @param string $style optional (rpc|document)
    * @param string $use optional (encoded|literal)
    * @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
    * @return string the message
    * @access public
    */
	public function serializeEnvelope($body, $headers = false, $namespaces = array(), $style = 'rpc', $use = 'encoded', $encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/')
	{
		$this->debug('In serializeEnvelope length=' . strlen($body) . ' body (max 1000 characters)=' . substr($body, 0, 1000) . (' style=' . $style . ' use=' . $use . ' encodingStyle=' . $encodingStyle));
		$this->debug('headers:');
		$this->appendDebug($this->varDump($headers));
		$this->debug('namespaces:');
		$this->appendDebug($this->varDump($namespaces));
		$ns_string = '';

		foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
			$ns_string .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if ($encodingStyle) {
			$ns_string = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"' . $ns_string;
		}

		if ($headers) {
			if (is_array($headers)) {
				$xml = '';

				foreach ($headers as $k => $v) {
					if (is_object($v) && get_class($v) == 'soapval') {
						$xml .= $this->serialize_val($v, false, false, false, false, false, $use);
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$headers = $xml;
				$this->debug('In serializeEnvelope, serialized array of headers to ' . $headers);
			}

			$headers = '<SOAP-ENV:Header>' . $headers . '</SOAP-ENV:Header>';
		}

		return '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?' . '>' . '<SOAP-ENV:Envelope' . $ns_string . '>' . $headers . '<SOAP-ENV:Body>' . $body . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
	}

	/**
	 * formats a string to be inserted into an HTML stream
	 *
	 * @param string $str The string to format
	 * @return string The formatted string
	 * @access public
	 * @deprecated
	 */
	public function formatDump($str)
	{
		$str = htmlspecialchars($str);
		return nl2br($str);
	}

	/**
	* contracts (changes namespace to prefix) a qualified name
	*
	* @param    string $qname qname
	* @return	string contracted qname
	* @access   private
	*/
	public function contractQname($qname)
	{
		if (strrpos($qname, ':')) {
			$name = substr($qname, strrpos($qname, ':') + 1);
			$ns = substr($qname, 0, strrpos($qname, ':'));
			$p = $this->getPrefixFromNamespace($ns);

			if ($p) {
				return $p . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
	* expands (changes prefix to namespace) a qualified name
	*
	* @param    string $qname qname
	* @return	string expanded qname
	* @access   private
	*/
	public function expandQname($qname)
	{
		if (strpos($qname, ':') && !preg_match('/^http:\\/\\//', $qname)) {
			$name = substr(strstr($qname, ':'), 1);
			$prefix = substr($qname, 0, strpos($qname, ':'));

			if (isset($this->namespaces[$prefix])) {
				return $this->namespaces[$prefix] . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
    * returns the local part of a prefixed string
    * returns the original string, if not prefixed
    *
    * @param string $str The prefixed string
    * @return string The local part
    * @access public
    */
	public function getLocalPart($str)
	{
		if ($sstr = strrchr($str, ':')) {
			return substr($sstr, 1);
		}

		return $str;
	}

	/**
    * returns the prefix part of a prefixed string
    * returns false, if not prefixed
    *
    * @param string $str The prefixed string
    * @return mixed The prefix or false if there is no prefix
    * @access public
    */
	public function getPrefix($str)
	{
		if ($pos = strrpos($str, ':')) {
			return substr($str, 0, $pos);
		}

		return false;
	}

	/**
    * pass it a prefix, it returns a namespace
    *
    * @param string $prefix The prefix
    * @return mixed The namespace, false if no namespace has the specified prefix
    * @access public
    */
	public function getNamespaceFromPrefix($prefix)
	{
		if (isset($this->namespaces[$prefix])) {
			return $this->namespaces[$prefix];
		}

		return false;
	}

	/**
    * returns the prefix for a given namespace (or prefix)
    * or false if no prefixes registered for the given namespace
    *
    * @param string $ns The namespace
    * @return mixed The prefix, false if the namespace has no prefixes
    * @access public
    */
	public function getPrefixFromNamespace($ns)
	{
		foreach ($this->namespaces as $p => $n) {
			if ($ns == $n || $ns == $p) {
				$this->usedNamespaces[$p] = $n;
				return $p;
			}
		}

		return false;
	}

	/**
    * returns the time in ODBC canonical form with microseconds
    *
    * @return string The time in ODBC canonical form with microseconds
    * @access public
    */
	public function getmicrotime()
	{
		if (function_exists('gettimeofday')) {
			$tod = gettimeofday();
			$sec = $tod['sec'];
			$usec = $tod['usec'];
		}
		else {
			$sec = time();
			$usec = 0;
		}

		return strftime('%Y-%m-%d %H:%M:%S', $sec) . '.' . sprintf('%06d', $usec);
	}

	/**
	 * Returns a string with the output of var_dump
	 *
	 * @param mixed $data The variable to var_dump
	 * @return string The output of var_dump
	 * @access public
	 */
	public function varDump($data)
	{
		ob_start();
		var_dump($data);
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	/**
	* represents the object as a string
	*
	* @return	string
	* @access   public
	*/
	public function __toString()
	{
		return $this->varDump($this);
	}
}

class nusoap_server extends nusoap_base
{
	/**
	 * HTTP headers of request
	 * @var array
	 * @access private
	 */
	public $headers = array();
	/**
	 * HTTP request
	 * @var string
	 * @access private
	 */
	public $request = '';
	/**
	 * SOAP headers from request (incomplete namespace resolution; special characters not escaped) (text)
	 * @var string
	 * @access public
	 */
	public $requestHeaders = '';
	/**
	 * SOAP Headers from request (parsed)
	 * @var mixed
	 * @access public
	 */
	public $requestHeader;
	/**
	 * SOAP body request portion (incomplete namespace resolution; special characters not escaped) (text)
	 * @var string
	 * @access public
	 */
	public $document = '';
	/**
	 * SOAP payload for request (text)
	 * @var string
	 * @access public
	 */
	public $requestSOAP = '';
	/**
	 * requested method namespace URI
	 * @var string
	 * @access private
	 */
	public $methodURI = '';
	/**
	 * name of method requested
	 * @var string
	 * @access private
	 */
	public $methodname = '';
	/**
	 * method parameters from request
	 * @var array
	 * @access private
	 */
	public $methodparams = array();
	/**
	 * SOAP Action from request
	 * @var string
	 * @access private
	 */
	public $SOAPAction = '';
	/**
	 * character set encoding of incoming (request) messages
	 * @var string
	 * @access public
	 */
	public $xml_encoding = '';
	/**
	 * toggles whether the parser decodes element content w/ utf8_decode()
	 * @var boolean
	 * @access public
	 */
	public $decode_utf8 = true;
	/**
	 * HTTP headers of response
	 * @var array
	 * @access public
	 */
	public $outgoing_headers = array();
	/**
	 * HTTP response
	 * @var string
	 * @access private
	 */
	public $response = '';
	/**
	 * SOAP headers for response (text or array of soapval or associative array)
	 * @var mixed
	 * @access public
	 */
	public $responseHeaders = '';
	/**
	 * SOAP payload for response (text)
	 * @var string
	 * @access private
	 */
	public $responseSOAP = '';
	/**
	 * method return value to place in response
	 * @var mixed
	 * @access private
	 */
	public $methodreturn = false;
	/**
	 * whether $methodreturn is a string of literal XML
	 * @var boolean
	 * @access public
	 */
	public $methodreturnisliteralxml = false;
	/**
	 * SOAP fault for response (or false)
	 * @var mixed
	 * @access private
	 */
	public $fault = false;
	/**
	 * text indication of result (for debugging)
	 * @var string
	 * @access private
	 */
	public $result = 'successful';
	/**
	 * assoc array of operations => opData; operations are added by the register()
	 * method or by parsing an external WSDL definition
	 * @var array
	 * @access private
	 */
	public $operations = array();
	/**
	 * wsdl instance (if one)
	 * @var mixed
	 * @access private
	 */
	public $wsdl = false;
	/**
	 * URL for WSDL (if one)
	 * @var mixed
	 * @access private
	 */
	public $externalWSDLURL = false;
	/**
	 * whether to append debug to response as XML comment
	 * @var boolean
	 * @access public
	 */
	public $debug_flag = false;
	/**
	 * Identification for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $title = 'NuSOAP';
	/**
	 * Version for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $version = '0.9.5';
	/**
	 * CVS revision for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $revision = '$Revision: 1.123 $';
	/**
     * Current error string (manipulated by getError/setError)
	 *
	 * @var string
	 * @access private
	 */
	public $error_str = '';
	/**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
	 *
	 * @var string
	 * @access private
	 */
	public $debug_str = '';
	/**
	 * toggles automatic encoding of special characters as entities
	 * (should always be true, I think)
	 *
	 * @var boolean
	 * @access private
	 */
	public $charencoding = true;
	/**
	 * the debug level for this instance
	 *
	 * @var	integer
	 * @access private
	 */
	public $debugLevel;
	/**
	* set schema version
	*
	* @var      string
	* @access   public
	*/
	public $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';
	/**
	* charset encoding for outgoing messages
	*
	* @var      string
	* @access   public
	*/
	public $soap_defencoding = 'ISO-8859-1';
	/**
	* namespaces in an array of prefix => uri
	*
	* this is "seeded" by a set of constants, but it may be altered by code
	*
	* @var      array
	* @access   public
	*/
	public $namespaces = array('SOAP-ENV' => 'http://schemas.xmlsoap.org/soap/envelope/', 'xsd' => 'http://www.w3.org/2001/XMLSchema', 'xsi' => 'http://www.w3.org/2001/XMLSchema-instance', 'SOAP-ENC' => 'http://schemas.xmlsoap.org/soap/encoding/');
	/**
	* namespaces used in the current context, e.g. during serialization
	*
	* @var      array
	* @access   private
	*/
	public $usedNamespaces = array();
	/**
	* XML Schema types in an array of uri => (array of xml type => php type)
	* is this legacy yet?
	* no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
	* @var      array
	* @access   public
	*/
	public $typemap = array(
		'http://www.w3.org/2001/XMLSchema'          => array('string' => 'string', 'boolean' => 'boolean', 'float' => 'double', 'double' => 'double', 'decimal' => 'double', 'duration' => '', 'dateTime' => 'string', 'time' => 'string', 'date' => 'string', 'gYearMonth' => '', 'gYear' => '', 'gMonthDay' => '', 'gDay' => '', 'gMonth' => '', 'hexBinary' => 'string', 'base64Binary' => 'string', 'anyType' => 'string', 'anySimpleType' => 'string', 'normalizedString' => 'string', 'token' => 'string', 'language' => '', 'NMTOKEN' => '', 'NMTOKENS' => '', 'Name' => '', 'NCName' => '', 'ID' => '', 'IDREF' => '', 'IDREFS' => '', 'ENTITY' => '', 'ENTITIES' => '', 'integer' => 'integer', 'nonPositiveInteger' => 'integer', 'negativeInteger' => 'integer', 'long' => 'integer', 'int' => 'integer', 'short' => 'integer', 'byte' => 'integer', 'nonNegativeInteger' => 'integer', 'unsignedLong' => '', 'unsignedInt' => '', 'unsignedShort' => '', 'unsignedByte' => '', 'positiveInteger' => ''),
		'http://www.w3.org/2000/10/XMLSchema'       => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://www.w3.org/1999/XMLSchema'          => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://soapinterop.org/xsd'                => array('SOAPStruct' => 'struct'),
		'http://schemas.xmlsoap.org/soap/encoding/' => array('base64' => 'string', 'array' => 'array', 'Array' => 'array'),
		'http://xml.apache.org/xml-soap'            => array('Map')
		);
	/**
	* XML entities to convert
	*
	* @var      array
	* @access   public
	* @deprecated
	* @see	expandEntities
	*/
	public $xmlEntities = array('quot' => '"', 'amp' => '&', 'lt' => '<', 'gt' => '>', 'apos' => '\'');

	/**
	* constructor
    * the optional parameter is a path to a WSDL file that you'd like to bind the server instance to.
	*
    * @param mixed $wsdl file path or URL (string), or wsdl instance (object)
	* @access   public
	*/
	public function nusoap_server($wsdl = false)
	{
		parent::nusoap_base();
		global $debug;
		global $HTTP_SERVER_VARS;

		if (isset($_SERVER)) {
			$this->debug('_SERVER is defined:');
			$this->appendDebug($this->varDump($_SERVER));
		}
		else if (isset($HTTP_SERVER_VARS)) {
			$this->debug('HTTP_SERVER_VARS is defined:');
			$this->appendDebug($this->varDump($HTTP_SERVER_VARS));
		}
		else {
			$this->debug('Neither _SERVER nor HTTP_SERVER_VARS is defined.');
		}

		if (isset($debug)) {
			$this->debug('In nusoap_server, set debug_flag=' . $debug . ' based on global flag');
			$this->debug_flag = $debug;
		}
		else if (isset($_SERVER['QUERY_STRING'])) {
			$qs = explode('&', $_SERVER['QUERY_STRING']);

			foreach ($qs as $v) {
				if (substr($v, 0, 6) == 'debug=') {
					$this->debug('In nusoap_server, set debug_flag=' . substr($v, 6) . ' based on query string #1');
					$this->debug_flag = substr($v, 6);
				}
			}
		}
		else {
			if (isset($HTTP_SERVER_VARS['QUERY_STRING'])) {
				$qs = explode('&', $HTTP_SERVER_VARS['QUERY_STRING']);

				foreach ($qs as $v) {
					if (substr($v, 0, 6) == 'debug=') {
						$this->debug('In nusoap_server, set debug_flag=' . substr($v, 6) . ' based on query string #2');
						$this->debug_flag = substr($v, 6);
					}
				}
			}
		}

		if ($wsdl) {
			$this->debug('In nusoap_server, WSDL is specified');
			if (is_object($wsdl) && get_class($wsdl) == 'wsdl') {
				$this->wsdl = $wsdl;
				$this->externalWSDLURL = $this->wsdl->wsdl;
				$this->debug('Use existing wsdl instance from ' . $this->externalWSDLURL);
			}
			else {
				$this->debug('Create wsdl from ' . $wsdl);
				$this->wsdl = new wsdl($wsdl);
				$this->externalWSDLURL = $wsdl;
			}

			$this->appendDebug($this->wsdl->getDebug());
			$this->wsdl->clearDebug();

			if ($err = $this->wsdl->getError()) {
				exit('WSDL ERROR: ' . $err);
			}
		}
	}

	/**
	* processes request and returns response
	*
	* @param    string $data usually is the value of $HTTP_RAW_POST_DATA
	* @access   public
	*/
	public function service($data)
	{
		global $HTTP_SERVER_VARS;

		if (isset($_SERVER['REQUEST_METHOD'])) {
			$rm = $_SERVER['REQUEST_METHOD'];
		}
		else if (isset($HTTP_SERVER_VARS['REQUEST_METHOD'])) {
			$rm = $HTTP_SERVER_VARS['REQUEST_METHOD'];
		}
		else {
			$rm = '';
		}

		if (isset($_SERVER['QUERY_STRING'])) {
			$qs = $_SERVER['QUERY_STRING'];
		}
		else if (isset($HTTP_SERVER_VARS['QUERY_STRING'])) {
			$qs = $HTTP_SERVER_VARS['QUERY_STRING'];
		}
		else {
			$qs = '';
		}

		$this->debug('In service, request method=' . $rm . ' query string=' . $qs . ' strlen($data)=' . strlen($data));

		if ($rm == 'POST') {
			$this->debug('In service, invoke the request');
			$this->parse_request($data);

			if (!$this->fault) {
				$this->invoke_method();
			}

			if (!$this->fault) {
				$this->serialize_return();
			}

			$this->send_response();
			return NULL;
		}

		if (preg_match('/wsdl/', $qs)) {
			$this->debug('In service, this is a request for WSDL');

			if ($this->externalWSDLURL) {
				if (strpos($this->externalWSDLURL, 'http://') !== false) {
					$this->debug('In service, re-direct for WSDL');
					header('Location: ' . $this->externalWSDLURL);
					return NULL;
				}

				$this->debug('In service, use file passthru for WSDL');
				header("Content-Type: text/xml\r\n");
				$pos = strpos($this->externalWSDLURL, 'file://');

				if ($pos === false) {
					$filename = $this->externalWSDLURL;
				}
				else {
					$filename = substr($this->externalWSDLURL, $pos + 7);
				}

				$fp = fopen($this->externalWSDLURL, 'r');
				fpassthru($fp);
				return NULL;
			}

			if ($this->wsdl) {
				$this->debug('In service, serialize WSDL');
				header("Content-Type: text/xml; charset=ISO-8859-1\r\n");
				print($this->wsdl->serialize($this->debug_flag));

				if ($this->debug_flag) {
					$this->debug('wsdl:');
					$this->appendDebug($this->varDump($this->wsdl));
					print($this->getDebugAsXMLComment());
					return NULL;
				}
			}
			else {
				$this->debug('In service, there is no WSDL');
				header("Content-Type: text/html; charset=ISO-8859-1\r\n");
				print('This service does not provide WSDL');
				return NULL;
			}
		}
		else {
			if ($this->wsdl) {
				$this->debug('In service, return Web description');
				print($this->wsdl->webDescription());
				return NULL;
			}

			$this->debug('In service, no Web description');
			header("Content-Type: text/html; charset=ISO-8859-1\r\n");
			print('This service does not provide a Web description');
		}
	}

	/**
	* parses HTTP request headers.
	*
	* The following fields are set by this function (when successful)
	*
	* headers
	* request
	* xml_encoding
	* SOAPAction
	*
	* @access   private
	*/
	public function parse_http_headers()
	{
		global $HTTP_SERVER_VARS;
		$this->request = '';
		$this->SOAPAction = '';

		if (function_exists('getallheaders')) {
			$this->debug('In parse_http_headers, use getallheaders');
			$headers = getallheaders();

			foreach ($headers as $k => $v) {
				$k = strtolower($k);
				$this->headers[$k] = $v;
				$this->request .= $k . ': ' . $v . "\r\n";
				$this->debug($k . ': ' . $v);
			}

			if (isset($this->headers['soapaction'])) {
				$this->SOAPAction = str_replace('"', '', $this->headers['soapaction']);
			}

			if (isset($this->headers['content-type']) && strpos($this->headers['content-type'], '=')) {
				$enc = str_replace('"', '', substr(strstr($this->headers['content-type'], '='), 1));

				if (preg_match('/^(ISO-8859-1|US-ASCII|UTF-8)$/i', $enc)) {
					$this->xml_encoding = strtoupper($enc);
					return NULL;
				}

				$this->xml_encoding = 'US-ASCII';
				return NULL;
			}

			$this->xml_encoding = 'ISO-8859-1';
			return NULL;
		}

		if (isset($_SERVER) && is_array($_SERVER)) {
			$this->debug('In parse_http_headers, use _SERVER');

			foreach ($_SERVER as $k => $v) {
				if (substr($k, 0, 5) == 'HTTP_') {
					$k = str_replace(' ', '-', strtolower(str_replace('_', ' ', substr($k, 5))));
				}
				else {
					$k = str_replace(' ', '-', strtolower(str_replace('_', ' ', $k)));
				}

				if ($k == 'soapaction') {
					$k = 'SOAPAction';
					$v = str_replace('"', '', $v);
					$v = str_replace('\\', '', $v);
					$this->SOAPAction = $v;
				}
				else {
					if ($k == 'content-type') {
						if (strpos($v, '=')) {
							$enc = substr(strstr($v, '='), 1);
							$enc = str_replace('"', '', $enc);
							$enc = str_replace('\\', '', $enc);

							if (preg_match('/^(ISO-8859-1|US-ASCII|UTF-8)$/i', $enc)) {
								$this->xml_encoding = strtoupper($enc);
							}
							else {
								$this->xml_encoding = 'US-ASCII';
							}
						}
						else {
							$this->xml_encoding = 'ISO-8859-1';
						}
					}
				}

				$this->headers[$k] = $v;
				$this->request .= $k . ': ' . $v . "\r\n";
				$this->debug($k . ': ' . $v);
			}

			return NULL;
		}

		if (is_array($HTTP_SERVER_VARS)) {
			$this->debug('In parse_http_headers, use HTTP_SERVER_VARS');

			foreach ($HTTP_SERVER_VARS as $k => $v) {
				if (substr($k, 0, 5) == 'HTTP_') {
					$k = str_replace(' ', '-', strtolower(str_replace('_', ' ', substr($k, 5))));
					$k = strtolower(substr($k, 5));
				}
				else {
					$k = str_replace(' ', '-', strtolower(str_replace('_', ' ', $k)));
					$k = strtolower($k);
				}

				if ($k == 'soapaction') {
					$k = 'SOAPAction';
					$v = str_replace('"', '', $v);
					$v = str_replace('\\', '', $v);
					$this->SOAPAction = $v;
				}
				else {
					if ($k == 'content-type') {
						if (strpos($v, '=')) {
							$enc = substr(strstr($v, '='), 1);
							$enc = str_replace('"', '', $enc);
							$enc = str_replace('\\', '', $enc);

							if (preg_match('/^(ISO-8859-1|US-ASCII|UTF-8)$/i', $enc)) {
								$this->xml_encoding = strtoupper($enc);
							}
							else {
								$this->xml_encoding = 'US-ASCII';
							}
						}
						else {
							$this->xml_encoding = 'ISO-8859-1';
						}
					}
				}

				$this->headers[$k] = $v;
				$this->request .= $k . ': ' . $v . "\r\n";
				$this->debug($k . ': ' . $v);
			}

			return NULL;
		}

		$this->debug('In parse_http_headers, HTTP headers not accessible');
		$this->setError('HTTP headers not accessible');
	}

	/**
	* parses a request
	*
	* The following fields are set by this function (when successful)
	*
	* headers
	* request
	* xml_encoding
	* SOAPAction
	* request
	* requestSOAP
	* methodURI
	* methodname
	* methodparams
	* requestHeaders
	* document
	*
	* This sets the fault field on error
	*
	* @param    string $data XML string
	* @access   private
	*/
	public function parse_request($data = '')
	{
		$this->debug('entering parse_request()');
		$this->parse_http_headers();
		$this->debug('got character encoding: ' . $this->xml_encoding);
		if (isset($this->headers['content-encoding']) && $this->headers['content-encoding'] != '') {
			$this->debug('got content encoding: ' . $this->headers['content-encoding']);
			if ($this->headers['content-encoding'] == 'deflate' || $this->headers['content-encoding'] == 'gzip') {
				if (function_exists('gzuncompress')) {
					if ($this->headers['content-encoding'] == 'deflate' && ($degzdata = @gzuncompress($data))) {
						$data = $degzdata;
					}
					else {
						if ($this->headers['content-encoding'] == 'gzip' && ($degzdata = gzinflate(substr($data, 10)))) {
							$data = $degzdata;
						}
						else {
							$this->fault('SOAP-ENV:Client', 'Errors occurred when trying to decode the data');
							return NULL;
						}
					}
				}
				else {
					$this->fault('SOAP-ENV:Client', 'This Server does not support compressed data');
					return NULL;
				}
			}
		}

		$this->request .= "\r\n" . $data;
		$data = $this->parseRequest($this->headers, $data);
		$this->requestSOAP = $data;
		$this->debug('leaving parse_request');
	}

	/**
	* invokes a PHP function for the requested SOAP method
	*
	* The following fields are set by this function (when successful)
	*
	* methodreturn
	*
	* Note that the PHP function that is called may also set the following
	* fields to affect the response sent to the client
	*
	* responseHeaders
	* outgoing_headers
	*
	* This sets the fault field on error
	*
	* @access   private
	*/
	public function invoke_method()
	{
		$this->debug('in invoke_method, methodname=' . $this->methodname . ' methodURI=' . $this->methodURI . ' SOAPAction=' . $this->SOAPAction);
		$orig_methodname = $this->methodname;

		if ($this->wsdl) {
			if ($this->opData = $this->wsdl->getOperationData($this->methodname)) {
				$this->debug('in invoke_method, found WSDL operation=' . $this->methodname);
				$this->appendDebug('opData=' . $this->varDump($this->opData));
			}
			else if ($this->opData = $this->wsdl->getOperationDataForSoapAction($this->SOAPAction)) {
				$this->debug('in invoke_method, found WSDL soapAction=' . $this->SOAPAction . ' for operation=' . $this->opData['name']);
				$this->appendDebug('opData=' . $this->varDump($this->opData));
				$this->methodname = $this->opData['name'];
			}
			else {
				$this->debug('in invoke_method, no WSDL for operation=' . $this->methodname);
				$this->fault('SOAP-ENV:Client', 'Operation \'' . $this->methodname . '\' is not defined in the WSDL for this service');
				return NULL;
			}
		}
		else {
			$this->debug('in invoke_method, no WSDL to validate method');
		}

		if (0 < strpos($this->methodname, '..')) {
			$delim = '..';
		}
		else if (0 < strpos($this->methodname, '.')) {
			$delim = '.';
		}
		else {
			$delim = '';
		}

		$this->debug('in invoke_method, delim=' . $delim);
		$class = '';
		$method = '';
		if (0 < strlen($delim) && substr_count($this->methodname, $delim) == 1) {
			$try_class = substr($this->methodname, 0, strpos($this->methodname, $delim));

			if (class_exists($try_class)) {
				$class = $try_class;
				$method = substr($this->methodname, strpos($this->methodname, $delim) + strlen($delim));
				$this->debug('in invoke_method, class=' . $class . ' method=' . $method . ' delim=' . $delim);
			}
			else {
				$this->debug('in invoke_method, class=' . $try_class . ' not found');
			}
		}
		else {
			$try_class = '';
			$this->debug('in invoke_method, no class to try');
		}

		if ($class == '') {
			if (!function_exists($this->methodname)) {
				$this->debug('in invoke_method, function \'' . $this->methodname . '\' not found!');
				$this->result = 'fault: method not found';
				$this->fault('SOAP-ENV:Client', 'method \'' . $this->methodname . '\'(\'' . $orig_methodname . '\') not defined in service(\'' . $try_class . '\' \'' . $delim . '\')');
				return NULL;
			}
		}
		else {
			$method_to_compare = substr(phpversion(), 0, 2) == '4.' ? strtolower($method) : $method;

			if (!in_array($method_to_compare, get_class_methods($class))) {
				$this->debug('in invoke_method, method \'' . $this->methodname . '\' not found in class \'' . $class . '\'!');
				$this->result = 'fault: method not found';
				$this->fault('SOAP-ENV:Client', 'method \'' . $this->methodname . '\'/\'' . $method_to_compare . '\'(\'' . $orig_methodname . '\') not defined in service/\'' . $class . '\'(\'' . $try_class . '\' \'' . $delim . '\')');
				return NULL;
			}
		}

		if (!$this->verify_method($this->methodname, $this->methodparams)) {
			$this->debug('ERROR: request not verified against method signature');
			$this->result = 'fault: request failed validation against method signature';
			$this->fault('SOAP-ENV:Client', 'Operation \'' . $this->methodname . '\' not defined in service.');
			return NULL;
		}

		$this->debug('in invoke_method, params:');
		$this->appendDebug($this->varDump($this->methodparams));
		$this->debug('in invoke_method, calling \'' . $this->methodname . '\'');

		if (!function_exists('call_user_func_array')) {
			if ($class == '') {
				$this->debug('in invoke_method, calling function using eval()');
				$funcCall = '$this->methodreturn = ' . $this->methodname . '(';
			}
			else if ($delim == '..') {
				$this->debug('in invoke_method, calling class method using eval()');
				$funcCall = '$this->methodreturn = ' . $class . '::' . $method . '(';
			}
			else {
				$this->debug('in invoke_method, calling instance method using eval()');
				$instname = '$inst_' . time();
				$funcCall = $instname . ' = new ' . $class . '(); ';
				$funcCall .= '$this->methodreturn = ' . $instname . '->' . $method . '(';
			}

			if ($this->methodparams) {
				foreach ($this->methodparams as $param) {
					if (is_array($param) || is_object($param)) {
						$this->fault('SOAP-ENV:Client', 'NuSOAP does not handle complexType parameters correctly when using eval; call_user_func_array must be available');
						return NULL;
					}

					$funcCall .= '"' . $param . '",';
				}

				$funcCall = substr($funcCall, 0, -1);
			}

			$funcCall .= ');';
			$this->debug('in invoke_method, function call: ' . $funcCall);
			@eval ($funcCall);
		}
		else {
			if ($class == '') {
				$this->debug('in invoke_method, calling function using call_user_func_array()');
				$call_arg = $this->methodname;
			}
			else if ($delim == '..') {
				$this->debug('in invoke_method, calling class method using call_user_func_array()');
				$call_arg = array($class, $method);
			}
			else {
				$this->debug('in invoke_method, calling instance method using call_user_func_array()');
				$instance = new $class();
				$call_arg = array(&$instance, $method);
			}

			if (is_array($this->methodparams)) {
				$this->methodreturn = call_user_func_array($call_arg, array_values($this->methodparams));
			}
			else {
				$this->methodreturn = call_user_func_array($call_arg, array());
			}
		}

		$this->debug('in invoke_method, methodreturn:');
		$this->appendDebug($this->varDump($this->methodreturn));
		$this->debug('in invoke_method, called method ' . $this->methodname . ', received data of type ' . gettype($this->methodreturn));
	}

	/**
	* serializes the return value from a PHP function into a full SOAP Envelope
	*
	* The following fields are set by this function (when successful)
	*
	* responseSOAP
	*
	* This sets the fault field on error
	*
	* @access   private
	*/
	public function serialize_return()
	{
		$this->debug('Entering serialize_return methodname: ' . $this->methodname . ' methodURI: ' . $this->methodURI);
		if (isset($this->methodreturn) && is_object($this->methodreturn) && (get_class($this->methodreturn) == 'soap_fault' || get_class($this->methodreturn) == 'nusoap_fault')) {
			$this->debug('got a fault object from method');
			$this->fault = $this->methodreturn;
			return NULL;
		}

		if ($this->methodreturnisliteralxml) {
			$return_val = $this->methodreturn;
		}
		else {
			$this->debug('got a(n) ' . gettype($this->methodreturn) . ' from method');
			$this->debug('serializing return value');

			if ($this->wsdl) {
				if (1 < sizeof($this->opData['output']['parts'])) {
					$this->debug('more than one output part, so use the method return unchanged');
					$opParams = $this->methodreturn;
				}
				else {
					if (sizeof($this->opData['output']['parts']) == 1) {
						$this->debug('exactly one output part, so wrap the method return in a simple array');
						$opParams = array($this->methodreturn);
					}
				}

				$return_val = $this->wsdl->serializeRPCParameters($this->methodname, 'output', $opParams);
				$this->appendDebug($this->wsdl->getDebug());
				$this->wsdl->clearDebug();

				if ($errstr = $this->wsdl->getError()) {
					$this->debug('got wsdl error: ' . $errstr);
					$this->fault('SOAP-ENV:Server', 'unable to serialize result');
					return NULL;
				}
			}
			else if (isset($this->methodreturn)) {
				$return_val = $this->serialize_val($this->methodreturn, 'return');
			}
			else {
				$return_val = '';
				$this->debug('in absence of WSDL, assume void return for backward compatibility');
			}
		}

		$this->debug('return value:');
		$this->appendDebug($this->varDump($return_val));
		$this->debug('serializing response');

		if ($this->wsdl) {
			$this->debug('have WSDL for serialization: style is ' . $this->opData['style']);

			if ($this->opData['style'] == 'rpc') {
				$this->debug('style is rpc for serialization: use is ' . $this->opData['output']['use']);

				if ($this->opData['output']['use'] == 'literal') {
					if ($this->methodURI) {
						$payload = '<ns1:' . $this->methodname . 'Response xmlns:ns1="' . $this->methodURI . '">' . $return_val . '</ns1:' . $this->methodname . 'Response>';
					}
					else {
						$payload = '<' . $this->methodname . 'Response>' . $return_val . '</' . $this->methodname . 'Response>';
					}
				}
				else if ($this->methodURI) {
					$payload = '<ns1:' . $this->methodname . 'Response xmlns:ns1="' . $this->methodURI . '">' . $return_val . '</ns1:' . $this->methodname . 'Response>';
				}
				else {
					$payload = '<' . $this->methodname . 'Response>' . $return_val . '</' . $this->methodname . 'Response>';
				}
			}
			else {
				$this->debug('style is not rpc for serialization: assume document');
				$payload = $return_val;
			}
		}
		else {
			$this->debug('do not have WSDL for serialization: assume rpc/encoded');
			$payload = '<ns1:' . $this->methodname . 'Response xmlns:ns1="' . $this->methodURI . '">' . $return_val . '</ns1:' . $this->methodname . 'Response>';
		}

		$this->result = 'successful';

		if ($this->wsdl) {
			$this->appendDebug($this->wsdl->getDebug());

			if (isset($this->opData['output']['encodingStyle'])) {
				$encodingStyle = $this->opData['output']['encodingStyle'];
			}
			else {
				$encodingStyle = '';
			}

			$this->responseSOAP = $this->serializeEnvelope($payload, $this->responseHeaders, $this->wsdl->usedNamespaces, $this->opData['style'], $this->opData['output']['use'], $encodingStyle);
		}
		else {
			$this->responseSOAP = $this->serializeEnvelope($payload, $this->responseHeaders);
		}

		$this->debug('Leaving serialize_return');
	}

	/**
	* sends an HTTP response
	*
	* The following fields are set by this function (when successful)
	*
	* outgoing_headers
	* response
	*
	* @access   private
	*/
	public function send_response()
	{
		$this->debug('Enter send_response');

		if ($this->fault) {
			$payload = $this->fault->serialize();
			$this->outgoing_headers[] = 'HTTP/1.0 500 Internal Server Error';
			$this->outgoing_headers[] = 'Status: 500 Internal Server Error';
		}
		else {
			$payload = $this->responseSOAP;
		}

		if (isset($this->debug_flag) && $this->debug_flag) {
			$payload .= $this->getDebugAsXMLComment();
		}

		$this->outgoing_headers[] = 'Server: ' . $this->title . ' Server v' . $this->version;
		preg_match('/\\$Revisio' . 'n: ([^ ]+)/', $this->revision, $rev);
		$this->outgoing_headers[] = 'X-SOAP-Server: ' . $this->title . '/' . $this->version . ' (' . $rev[1] . ')';
		$payload = $this->getHTTPBody($payload);
		$type = $this->getHTTPContentType();
		$charset = $this->getHTTPContentTypeCharset();
		$this->outgoing_headers[] = 'Content-Type: ' . $type . ($charset ? '; charset=' . $charset : '');
		if (1024 < strlen($payload) && isset($this->headers) && isset($this->headers['accept-encoding'])) {
			if (strstr($this->headers['accept-encoding'], 'gzip')) {
				if (function_exists('gzencode')) {
					if (isset($this->debug_flag) && $this->debug_flag) {
						$payload .= '<!-- Content being gzipped -->';
					}

					$this->outgoing_headers[] = 'Content-Encoding: gzip';
					$payload = gzencode($payload);
				}
				else {
					if (isset($this->debug_flag) && $this->debug_flag) {
						$payload .= '<!-- Content will not be gzipped: no gzencode -->';
					}
				}
			}
			else {
				if (strstr($this->headers['accept-encoding'], 'deflate')) {
					if (function_exists('gzdeflate')) {
						if (isset($this->debug_flag) && $this->debug_flag) {
							$payload .= '<!-- Content being deflated -->';
						}

						$this->outgoing_headers[] = 'Content-Encoding: deflate';
						$payload = gzdeflate($payload);
					}
					else {
						if (isset($this->debug_flag) && $this->debug_flag) {
							$payload .= '<!-- Content will not be deflated: no gzcompress -->';
						}
					}
				}
			}
		}

		$this->outgoing_headers[] = 'Content-Length: ' . strlen($payload);
		reset($this->outgoing_headers);

		foreach ($this->outgoing_headers as $hdr) {
			header($hdr, false);
		}

		print($payload);
		$this->response = join("\r\n", $this->outgoing_headers) . "\r\n\r\n" . $payload;
	}

	/**
	* takes the value that was created by parsing the request
	* and compares to the method's signature, if available.
	*
	* @param	string	$operation	The operation to be invoked
	* @param	array	$request	The array of parameter values
	* @return	boolean	Whether the operation was found
	* @access   private
	*/
	public function verify_method($operation, $request)
	{
		if (isset($this->wsdl) && is_object($this->wsdl)) {
			if ($this->wsdl->getOperationData($operation)) {
				return true;
			}
		}
		else {
			if (isset($this->operations[$operation])) {
				return true;
			}
		}

		return false;
	}

	/**
	* processes SOAP message received from client
	*
	* @param	array	$headers	The HTTP headers
	* @param	string	$data		unprocessed request data from client
	* @return	mixed	value of the message, decoded into a PHP type
	* @access   private
	*/
	public function parseRequest($headers, $data)
	{
		$this->debug('Entering parseRequest() for data of length ' . strlen($data) . ' headers:');
		$this->appendDebug($this->varDump($headers));

		if (!isset($headers['content-type'])) {
			$this->setError('Request not of type text/xml (no content-type header)');
			return false;
		}

		if (!strstr($headers['content-type'], 'text/xml')) {
			$this->setError('Request not of type text/xml');
			return false;
		}

		if (strpos($headers['content-type'], '=')) {
			$enc = str_replace('"', '', substr(strstr($headers['content-type'], '='), 1));
			$this->debug('Got response encoding: ' . $enc);

			if (preg_match('/^(ISO-8859-1|US-ASCII|UTF-8)$/i', $enc)) {
				$this->xml_encoding = strtoupper($enc);
			}
			else {
				$this->xml_encoding = 'US-ASCII';
			}
		}
		else {
			$this->xml_encoding = 'ISO-8859-1';
		}

		$this->debug('Use encoding: ' . $this->xml_encoding . ' when creating nusoap_parser');
		$parser = new nusoap_parser($data, $this->xml_encoding, '', $this->decode_utf8);
		$this->debug("parser debug: \n" . $parser->getDebug());

		if ($err = $parser->getError()) {
			$this->result = 'fault: error in msg parsing: ' . $err;
			$this->fault('SOAP-ENV:Client', "error in msg parsing:\n" . $err);
			return NULL;
		}

		$this->methodURI = $parser->root_struct_namespace;
		$this->methodname = $parser->root_struct_name;
		$this->debug('methodname: ' . $this->methodname . ' methodURI: ' . $this->methodURI);
		$this->debug('calling parser->get_soapbody()');
		$this->methodparams = $parser->get_soapbody();
		$this->requestHeaders = $parser->getHeaders();
		$this->requestHeader = $parser->get_soapheader();
		$this->document = $parser->document;
	}

	/**
	* gets the HTTP body for the current response.
	*
	* @param string $soapmsg The SOAP payload
	* @return string The HTTP body, which includes the SOAP payload
	* @access private
	*/
	public function getHTTPBody($soapmsg)
	{
		return $soapmsg;
	}

	/**
	* gets the HTTP content type for the current response.
	*
	* Note: getHTTPBody must be called before this.
	*
	* @return string the HTTP content type for the current response.
	* @access private
	*/
	public function getHTTPContentType()
	{
		return 'text/xml';
	}

	/**
	* gets the HTTP content type charset for the current response.
	* returns false for non-text content types.
	*
	* Note: getHTTPBody must be called before this.
	*
	* @return string the HTTP content type charset for the current response.
	* @access private
	*/
	public function getHTTPContentTypeCharset()
	{
		return $this->soap_defencoding;
	}

	/**
	* add a method to the dispatch map (this has been replaced by the register method)
	*
	* @param    string $methodname
	* @param    string $in array of input values
	* @param    string $out array of output values
	* @access   public
	* @deprecated
	*/
	public function add_to_map($methodname, $in, $out)
	{
		$this->operations[$methodname] = array('name' => $methodname, 'in' => $in, 'out' => $out);
	}

	/**
	* register a service function with the server
	*
	* @param    string $name the name of the PHP function, class.method or class..method
	* @param    array $in assoc array of input values: key = param name, value = param type
	* @param    array $out assoc array of output values: key = param name, value = param type
	* @param	mixed $namespace the element namespace for the method or false
	* @param	mixed $soapaction the soapaction for the method or false
	* @param	mixed $style optional (rpc|document) or false Note: when 'document' is specified, parameter and return wrappers are created for you automatically
	* @param	mixed $use optional (encoded|literal) or false
	* @param	string $documentation optional Description to include in WSDL
	* @param	string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
	* @access   public
	*/
	public function register($name, $in = array(), $out = array(), $namespace = false, $soapaction = false, $style = false, $use = false, $documentation = '', $encodingStyle = '')
	{
		global $HTTP_SERVER_VARS;

		if ($this->externalWSDLURL) {
			exit('You cannot bind to an external WSDL file, and register methods outside of it! Please choose either WSDL or no WSDL.');
		}

		if (!$name) {
			exit('You must specify a name when you register an operation');
		}

		if (!is_array($in)) {
			exit('You must provide an array for operation inputs');
		}

		if (!is_array($out)) {
			exit('You must provide an array for operation outputs');
		}

		if (false == $namespace) {
		}

		if (false == $soapaction) {
			if (isset($_SERVER)) {
				$SERVER_NAME = $_SERVER['SERVER_NAME'];
				$SCRIPT_NAME = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
				$HTTPS = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : (isset($HTTP_SERVER_VARS['HTTPS']) ? $HTTP_SERVER_VARS['HTTPS'] : 'off');
			}
			else if (isset($HTTP_SERVER_VARS)) {
				$SERVER_NAME = $HTTP_SERVER_VARS['SERVER_NAME'];
				$SCRIPT_NAME = isset($HTTP_SERVER_VARS['PHP_SELF']) ? $HTTP_SERVER_VARS['PHP_SELF'] : $HTTP_SERVER_VARS['SCRIPT_NAME'];
				$HTTPS = isset($HTTP_SERVER_VARS['HTTPS']) ? $HTTP_SERVER_VARS['HTTPS'] : 'off';
			}
			else {
				$this->setError('Neither _SERVER nor HTTP_SERVER_VARS is available');
			}

			if ($HTTPS == '1' || $HTTPS == 'on') {
				$SCHEME = 'https';
			}
			else {
				$SCHEME = 'http';
			}

			$soapaction = $SCHEME . '://' . $SERVER_NAME . $SCRIPT_NAME . '/' . $name;
		}

		if (false == $style) {
			$style = 'rpc';
		}

		if (false == $use) {
			$use = 'encoded';
		}

		if ($use == 'encoded' && $encodingStyle == '') {
			$encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/';
		}

		$this->operations[$name] = array('name' => $name, 'in' => $in, 'out' => $out, 'namespace' => $namespace, 'soapaction' => $soapaction, 'style' => $style);

		if ($this->wsdl) {
			$this->wsdl->addOperation($name, $in, $out, $namespace, $soapaction, $style, $use, $documentation, $encodingStyle);
		}

		return true;
	}

	/**
	* Specify a fault to be returned to the client.
	* This also acts as a flag to the server that a fault has occured.
	*
	* @param	string $faultcode
	* @param	string $faultstring
	* @param	string $faultactor
	* @param	string $faultdetail
	* @access   public
	*/
	public function fault($faultcode, $faultstring, $faultactor = '', $faultdetail = '')
	{
		if ($faultdetail == '' && $this->debug_flag) {
			$faultdetail = $this->getDebug();
		}

		$this->fault = new nusoap_fault($faultcode, $faultactor, $faultstring, $faultdetail);
		$this->fault->soap_defencoding = $this->soap_defencoding;
	}

	/**
    * Sets up wsdl object.
    * Acts as a flag to enable internal WSDL generation
    *
    * @param string $serviceName, name of the service
    * @param mixed $namespace optional 'tns' service namespace or false
    * @param mixed $endpoint optional URL of service endpoint or false
    * @param string $style optional (rpc|document) WSDL style (also specified by operation)
    * @param string $transport optional SOAP transport
    * @param mixed $schemaTargetNamespace optional 'types' targetNamespace for service schema or false
    */
	public function configureWSDL($serviceName, $namespace = false, $endpoint = false, $style = 'rpc', $transport = 'http://schemas.xmlsoap.org/soap/http', $schemaTargetNamespace = false)
	{
		global $HTTP_SERVER_VARS;

		if (isset($_SERVER)) {
			$SERVER_NAME = $_SERVER['SERVER_NAME'];
			$SERVER_PORT = $_SERVER['SERVER_PORT'];
			$SCRIPT_NAME = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
			$HTTPS = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : (isset($HTTP_SERVER_VARS['HTTPS']) ? $HTTP_SERVER_VARS['HTTPS'] : 'off');
		}
		else if (isset($HTTP_SERVER_VARS)) {
			$SERVER_NAME = $HTTP_SERVER_VARS['SERVER_NAME'];
			$SERVER_PORT = $HTTP_SERVER_VARS['SERVER_PORT'];
			$SCRIPT_NAME = isset($HTTP_SERVER_VARS['PHP_SELF']) ? $HTTP_SERVER_VARS['PHP_SELF'] : $HTTP_SERVER_VARS['SCRIPT_NAME'];
			$HTTPS = isset($HTTP_SERVER_VARS['HTTPS']) ? $HTTP_SERVER_VARS['HTTPS'] : 'off';
		}
		else {
			$this->setError('Neither _SERVER nor HTTP_SERVER_VARS is available');
		}

		$colon = strpos($SERVER_NAME, ':');

		if ($colon) {
			$SERVER_NAME = substr($SERVER_NAME, 0, $colon);
		}

		if ($SERVER_PORT == 80) {
			$SERVER_PORT = '';
		}
		else {
			$SERVER_PORT = ':' . $SERVER_PORT;
		}

		if (false == $namespace) {
			$namespace = 'http://' . $SERVER_NAME . '/soap/' . $serviceName;
		}

		if (false == $endpoint) {
			if ($HTTPS == '1' || $HTTPS == 'on') {
				$SCHEME = 'https';
			}
			else {
				$SCHEME = 'http';
			}

			$endpoint = $SCHEME . '://' . $SERVER_NAME . $SERVER_PORT . $SCRIPT_NAME;
		}

		if (false == $schemaTargetNamespace) {
			$schemaTargetNamespace = $namespace;
		}

		$this->wsdl = new wsdl();
		$this->wsdl->serviceName = $serviceName;
		$this->wsdl->endpoint = $endpoint;
		$this->wsdl->namespaces['tns'] = $namespace;
		$this->wsdl->namespaces['soap'] = 'http://schemas.xmlsoap.org/wsdl/soap/';
		$this->wsdl->namespaces['wsdl'] = 'http://schemas.xmlsoap.org/wsdl/';

		if ($schemaTargetNamespace != $namespace) {
			$this->wsdl->namespaces['types'] = $schemaTargetNamespace;
		}

		$this->wsdl->schemas[$schemaTargetNamespace][0] = new nusoap_xmlschema('', '', $this->wsdl->namespaces);

		if ($style == 'document') {
			$this->wsdl->schemas[$schemaTargetNamespace][0]->schemaInfo['elementFormDefault'] = 'qualified';
		}

		$this->wsdl->schemas[$schemaTargetNamespace][0]->schemaTargetNamespace = $schemaTargetNamespace;
		$this->wsdl->schemas[$schemaTargetNamespace][0]->imports['http://schemas.xmlsoap.org/soap/encoding/'][0] = array('location' => '', 'loaded' => true);
		$this->wsdl->schemas[$schemaTargetNamespace][0]->imports['http://schemas.xmlsoap.org/wsdl/'][0] = array('location' => '', 'loaded' => true);
		$this->wsdl->bindings[$serviceName . 'Binding'] = array('name' => $serviceName . 'Binding', 'style' => $style, 'transport' => $transport, 'portType' => $serviceName . 'PortType');
		$this->wsdl->ports[$serviceName . 'Port'] = array('binding' => $serviceName . 'Binding', 'location' => $endpoint, 'bindingType' => 'http://schemas.xmlsoap.org/wsdl/soap/');
	}

	/**
	* constructor
	*
	* @access	public
	*/
	public function nusoap_base()
	{
		$this->debugLevel = $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* gets the global debug level, which applies to future instances
	*
	* @return	integer	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getGlobalDebugLevel()
	{
		return $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* sets the global debug level, which applies to future instances
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setGlobalDebugLevel($level)
	{
		$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = $level;
	}

	/**
	* gets the debug level for this instance
	*
	* @return	int	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}

	/**
	* sets the debug level for this instance
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}

	/**
	* adds debug data to the instance debug string with formatting
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function debug($string)
	{
		if (0 < $this->debugLevel) {
			$this->appendDebug($this->getmicrotime() . ' ' . get_class($this) . (': ' . $string . "\n"));
		}
	}

	/**
	* adds debug data to the instance debug string without formatting
	*
	* @param    string $string debug data
	* @access   public
	*/
	public function appendDebug($string)
	{
		if (0 < $this->debugLevel) {
			$this->debug_str .= $string;
		}
	}

	/**
	* clears the current debug data for this instance
	*
	* @access   public
	*/
	public function clearDebug()
	{
		$this->debug_str = '';
	}

	/**
	* gets the current debug data for this instance
	*
	* @return   debug data
	* @access   public
	*/
	public function& getDebug()
	{
		return $this->debug_str;
	}

	/**
	* gets the current debug data for this instance as an XML comment
	* this may change the contents of the debug data
	*
	* @return   debug data as an XML comment
	* @access   public
	*/
	public function& getDebugAsXMLComment()
	{
		while (strpos($this->debug_str, '--')) {
			$this->debug_str = str_replace('--', '- -', $this->debug_str);
		}

		$ret = "<!--\n" . $this->debug_str . "\n-->";
		return $ret;
	}

	/**
	* expands entities, e.g. changes '<' to '&lt;'.
	*
	* @param	string	$val	The string in which to expand entities.
	* @access	private
	*/
	public function expandEntities($val)
	{
		if ($this->charencoding) {
			$val = str_replace('&', '&amp;', $val);
			$val = str_replace('\'', '&apos;', $val);
			$val = str_replace('"', '&quot;', $val);
			$val = str_replace('<', '&lt;', $val);
			$val = str_replace('>', '&gt;', $val);
		}

		return $val;
	}

	/**
	* returns error string if present
	*
	* @return   mixed error string or false
	* @access   public
	*/
	public function getError()
	{
		if ($this->error_str != '') {
			return $this->error_str;
		}

		return false;
	}

	/**
	* sets error string
	*
	* @return   boolean $string error string
	* @access   private
	*/
	public function setError($str)
	{
		$this->error_str = $str;
	}

	/**
	* detect if array is a simple array or a struct (associative array)
	*
	* @param	mixed	$val	The PHP array
	* @return	string	(arraySimple|arrayStruct)
	* @access	private
	*/
	public function isArraySimpleOrStruct($val)
	{
		$keyList = array_keys($val);

		foreach ($keyList as $keyListValue) {
			if (!is_int($keyListValue)) {
				return 'arrayStruct';
			}
		}

		return 'arraySimple';
	}

	/**
	* serializes PHP values in accordance w/ section 5. Type information is
	* not serialized if $use == 'literal'.
	*
	* @param	mixed	$val	The value to serialize
	* @param	string	$name	The name (local part) of the XML element
	* @param	string	$type	The XML schema type (local part) for the element
	* @param	string	$name_ns	The namespace for the name of the XML element
	* @param	string	$type_ns	The namespace for the type of the element
	* @param	array	$attributes	The attributes to serialize as name=>value pairs
	* @param	string	$use	The WSDL "use" (encoded|literal)
	* @param	boolean	$soapval	Whether this is called from soapval.
	* @return	string	The serialized element, possibly with child elements
    * @access	public
	*/
	public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = 'encoded', $soapval = false)
	{
		$this->debug('in serialize_val: name=' . $name . ', type=' . $type . ', name_ns=' . $name_ns . ', type_ns=' . $type_ns . ', use=' . $use . ', soapval=' . $soapval);
		$this->appendDebug('value=' . $this->varDump($val));
		$this->appendDebug('attributes=' . $this->varDump($attributes));
		if (is_object($val) && get_class($val) == 'soapval' && !$soapval) {
			$this->debug('serialize_val: serialize soapval');
			$xml = $val->serialize($use);
			$this->appendDebug($val->getDebug());
			$val->clearDebug();
			$this->debug('serialize_val of soapval returning ' . $xml);
			return $xml;
		}

		if (is_numeric($name)) {
			$name = '__numeric_' . $name;
		}
		else {
			if (!$name) {
				$name = 'noname';
			}
		}

		$xmlns = '';

		if ($name_ns) {
			$prefix = 'nu' . rand(1000, 9999);
			$name = $prefix . ':' . $name;
			$xmlns .= ' xmlns:' . $prefix . '="' . $name_ns . '"';
		}

		if ($type_ns != '' && $type_ns == $this->namespaces['xsd']) {
			$type_prefix = 'xsd';
		}
		else {
			if ($type_ns) {
				$type_prefix = 'ns' . rand(1000, 9999);
				$xmlns .= ' xmlns:' . $type_prefix . '="' . $type_ns . '"';
			}
		}

		$atts = '';

		if ($attributes) {
			foreach ($attributes as $k => $v) {
				$atts .= ' ' . $k . '="' . $this->expandEntities($v) . '"';
			}
		}

		if (is_null($val)) {
			$this->debug('serialize_val: serialize null');

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '/>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			$xml = '<' . $name . $xmlns . $type_str . $atts . ' xsi:nil="true"/>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		if ($type != '' && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
			$this->debug('serialize_val: serialize xsd built-in primitive type');

			if (is_bool($val)) {
				if ($type == 'boolean') {
					$val = $val ? 'true' : 'false';
				}
				else {
					if (!$val) {
						$val = 0;
					}
				}
			}
			else {
				if (is_string($val)) {
					$val = $this->expandEntities($val);
				}
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			$xml = '<' . $name . $xmlns . ' xsi:type="xsd:' . $type . '"' . $atts . '>' . $val . '</' . $name . '>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		$xml = '';
		switch (true) {
		case is_bool($val) || $type == 'boolean':
			$this->debug('serialize_val: serialize boolean');

			if ($type == 'boolean') {
				$val = $val ? 'true' : 'false';
			}
			else {
				if (!$val) {
					$val = 0;
				}
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:boolean"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_int($val) || is_long($val) || $type == 'int':
			$this->debug('serialize_val: serialize int');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:int"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_float($val) || is_double($val) || $type == 'float':
			$this->debug('serialize_val: serialize float');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:float"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_string($val) || $type == 'string':
			$this->debug('serialize_val: serialize string');
			$val = $this->expandEntities($val);

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:string"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_object($val):
			$this->debug('serialize_val: serialize object');

			if (get_class($val) == 'soapval') {
				$this->debug('serialize_val: serialize soapval object');
				$pXml = $val->serialize($use);
				$this->appendDebug($val->getDebug());
				$val->clearDebug();
			}
			else {
				if (!$name) {
					$name = get_class($val);
					$this->debug('In serialize_val, used class name ' . $name . ' as element name');
				}
				else {
					$this->debug('In serialize_val, do not override name ' . $name . ' for element name for class ' . get_class($val));
				}

				foreach (get_object_vars($val) as $k => $v) {
					$pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $pXml . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . $type_str . $atts . '>' . $pXml . '</' . $name . '>';
			}

			break;

		case is_array($val) || $type:
			$valueType = $this->isArraySimpleOrStruct($val);
			if ($valueType == 'arraySimple' || preg_match('/^ArrayOf/', $type)) {
				$this->debug('serialize_val: serialize array');
				$i = 0;
				if (is_array($val) && 0 < count($val)) {
					foreach ($val as $v) {
						if (is_object($v) && get_class($v) == 'soapval') {
							$tt_ns = $v->type_ns;
							$tt = $v->type;
						}
						else if (is_array($v)) {
							$tt = $this->isArraySimpleOrStruct($v);
						}
						else {
							$tt = gettype($v);
						}

						$array_types[$tt] = 1;
						$xml .= $this->serialize_val($v, 'item', false, false, false, false, $use);
						++$i;
					}

					if (1 < count($array_types)) {
						$array_typename = 'xsd:anyType';
					}
					else {
						if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
							if ($tt == 'integer') {
								$tt = 'int';
							}

							$array_typename = 'xsd:' . $tt;
						}
						else {
							if (isset($tt) && $tt == 'arraySimple') {
								$array_typename = 'SOAP-ENC:Array';
							}
							else {
								if (isset($tt) && $tt == 'arrayStruct') {
									$array_typename = 'unnamed_struct_use_soapval';
								}
								else {
									if ($tt_ns != '' && $tt_ns == $this->namespaces['xsd']) {
										$array_typename = 'xsd:' . $tt;
									}
									else if ($tt_ns) {
										$tt_prefix = 'ns' . rand(1000, 9999);
										$array_typename = $tt_prefix . ':' . $tt;
										$xmlns .= ' xmlns:' . $tt_prefix . '="' . $tt_ns . '"';
									}
									else {
										$array_typename = $tt;
									}
								}
							}
						}
					}

					$array_type = $i;

					if ($use == 'literal') {
						$type_str = '';
					}
					else {
						if (isset($type) && isset($type_prefix)) {
							$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
						}
						else {
							$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="' . $array_typename . ('[' . $array_type . ']"');
						}
					}
				}
				else if ($use == 'literal') {
					$type_str = '';
				}
				else {
					if (isset($type) && isset($type_prefix)) {
						$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
					}
					else {
						$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="xsd:anyType[0]"';
					}
				}

				$xml = '<' . $name . $xmlns . $type_str . $atts . '>' . $xml . ('</' . $name . '>');
			}
			else {
				$this->debug('serialize_val: serialize struct');
				if (isset($type) && isset($type_prefix)) {
					$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
				}
				else {
					$type_str = '';
				}

				if ($use == 'literal') {
					$xml .= '<' . $name . $xmlns . $atts . '>';
				}
				else {
					$xml .= '<' . $name . $xmlns . $type_str . $atts . '>';
				}

				foreach ($val as $k => $v) {
					if ($type == 'Map' && $type_ns == 'http://xml.apache.org/xml-soap') {
						$xml .= '<item>';
						$xml .= $this->serialize_val($k, 'key', false, false, false, false, $use);
						$xml .= $this->serialize_val($v, 'value', false, false, false, false, $use);
						$xml .= '</item>';
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$xml .= '</' . $name . '>';
			}

			break;

		default:
			$this->debug('serialize_val: serialize unknown');
			$xml .= 'not detected, got ' . gettype($val) . ' for ' . $val;
			break;
		}

		$this->debug('serialize_val returning ' . $xml);
		return $xml;
	}

	/**
    * serializes a message
    *
    * @param string $body the XML of the SOAP body
    * @param mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
    * @param array $namespaces optional the namespaces used in generating the body and headers
    * @param string $style optional (rpc|document)
    * @param string $use optional (encoded|literal)
    * @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
    * @return string the message
    * @access public
    */
	public function serializeEnvelope($body, $headers = false, $namespaces = array(), $style = 'rpc', $use = 'encoded', $encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/')
	{
		$this->debug('In serializeEnvelope length=' . strlen($body) . ' body (max 1000 characters)=' . substr($body, 0, 1000) . (' style=' . $style . ' use=' . $use . ' encodingStyle=' . $encodingStyle));
		$this->debug('headers:');
		$this->appendDebug($this->varDump($headers));
		$this->debug('namespaces:');
		$this->appendDebug($this->varDump($namespaces));
		$ns_string = '';

		foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
			$ns_string .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if ($encodingStyle) {
			$ns_string = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"' . $ns_string;
		}

		if ($headers) {
			if (is_array($headers)) {
				$xml = '';

				foreach ($headers as $k => $v) {
					if (is_object($v) && get_class($v) == 'soapval') {
						$xml .= $this->serialize_val($v, false, false, false, false, false, $use);
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$headers = $xml;
				$this->debug('In serializeEnvelope, serialized array of headers to ' . $headers);
			}

			$headers = '<SOAP-ENV:Header>' . $headers . '</SOAP-ENV:Header>';
		}

		return '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?' . '>' . '<SOAP-ENV:Envelope' . $ns_string . '>' . $headers . '<SOAP-ENV:Body>' . $body . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
	}

	/**
	 * formats a string to be inserted into an HTML stream
	 *
	 * @param string $str The string to format
	 * @return string The formatted string
	 * @access public
	 * @deprecated
	 */
	public function formatDump($str)
	{
		$str = htmlspecialchars($str);
		return nl2br($str);
	}

	/**
	* contracts (changes namespace to prefix) a qualified name
	*
	* @param    string $qname qname
	* @return	string contracted qname
	* @access   private
	*/
	public function contractQname($qname)
	{
		if (strrpos($qname, ':')) {
			$name = substr($qname, strrpos($qname, ':') + 1);
			$ns = substr($qname, 0, strrpos($qname, ':'));
			$p = $this->getPrefixFromNamespace($ns);

			if ($p) {
				return $p . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
	* expands (changes prefix to namespace) a qualified name
	*
	* @param    string $qname qname
	* @return	string expanded qname
	* @access   private
	*/
	public function expandQname($qname)
	{
		if (strpos($qname, ':') && !preg_match('/^http:\\/\\//', $qname)) {
			$name = substr(strstr($qname, ':'), 1);
			$prefix = substr($qname, 0, strpos($qname, ':'));

			if (isset($this->namespaces[$prefix])) {
				return $this->namespaces[$prefix] . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
    * returns the local part of a prefixed string
    * returns the original string, if not prefixed
    *
    * @param string $str The prefixed string
    * @return string The local part
    * @access public
    */
	public function getLocalPart($str)
	{
		if ($sstr = strrchr($str, ':')) {
			return substr($sstr, 1);
		}

		return $str;
	}

	/**
    * returns the prefix part of a prefixed string
    * returns false, if not prefixed
    *
    * @param string $str The prefixed string
    * @return mixed The prefix or false if there is no prefix
    * @access public
    */
	public function getPrefix($str)
	{
		if ($pos = strrpos($str, ':')) {
			return substr($str, 0, $pos);
		}

		return false;
	}

	/**
    * pass it a prefix, it returns a namespace
    *
    * @param string $prefix The prefix
    * @return mixed The namespace, false if no namespace has the specified prefix
    * @access public
    */
	public function getNamespaceFromPrefix($prefix)
	{
		if (isset($this->namespaces[$prefix])) {
			return $this->namespaces[$prefix];
		}

		return false;
	}

	/**
    * returns the prefix for a given namespace (or prefix)
    * or false if no prefixes registered for the given namespace
    *
    * @param string $ns The namespace
    * @return mixed The prefix, false if the namespace has no prefixes
    * @access public
    */
	public function getPrefixFromNamespace($ns)
	{
		foreach ($this->namespaces as $p => $n) {
			if ($ns == $n || $ns == $p) {
				$this->usedNamespaces[$p] = $n;
				return $p;
			}
		}

		return false;
	}

	/**
    * returns the time in ODBC canonical form with microseconds
    *
    * @return string The time in ODBC canonical form with microseconds
    * @access public
    */
	public function getmicrotime()
	{
		if (function_exists('gettimeofday')) {
			$tod = gettimeofday();
			$sec = $tod['sec'];
			$usec = $tod['usec'];
		}
		else {
			$sec = time();
			$usec = 0;
		}

		return strftime('%Y-%m-%d %H:%M:%S', $sec) . '.' . sprintf('%06d', $usec);
	}

	/**
	 * Returns a string with the output of var_dump
	 *
	 * @param mixed $data The variable to var_dump
	 * @return string The output of var_dump
	 * @access public
	 */
	public function varDump($data)
	{
		ob_start();
		var_dump($data);
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	/**
	* represents the object as a string
	*
	* @return	string
	* @access   public
	*/
	public function __toString()
	{
		return $this->varDump($this);
	}
}

class soap_server extends nusoap_server
{
	/**
	 * HTTP headers of request
	 * @var array
	 * @access private
	 */
	public $headers = array();
	/**
	 * HTTP request
	 * @var string
	 * @access private
	 */
	public $request = '';
	/**
	 * SOAP headers from request (incomplete namespace resolution; special characters not escaped) (text)
	 * @var string
	 * @access public
	 */
	public $requestHeaders = '';
	/**
	 * SOAP Headers from request (parsed)
	 * @var mixed
	 * @access public
	 */
	public $requestHeader;
	/**
	 * SOAP body request portion (incomplete namespace resolution; special characters not escaped) (text)
	 * @var string
	 * @access public
	 */
	public $document = '';
	/**
	 * SOAP payload for request (text)
	 * @var string
	 * @access public
	 */
	public $requestSOAP = '';
	/**
	 * requested method namespace URI
	 * @var string
	 * @access private
	 */
	public $methodURI = '';
	/**
	 * name of method requested
	 * @var string
	 * @access private
	 */
	public $methodname = '';
	/**
	 * method parameters from request
	 * @var array
	 * @access private
	 */
	public $methodparams = array();
	/**
	 * SOAP Action from request
	 * @var string
	 * @access private
	 */
	public $SOAPAction = '';
	/**
	 * character set encoding of incoming (request) messages
	 * @var string
	 * @access public
	 */
	public $xml_encoding = '';
	/**
	 * toggles whether the parser decodes element content w/ utf8_decode()
	 * @var boolean
	 * @access public
	 */
	public $decode_utf8 = true;
	/**
	 * HTTP headers of response
	 * @var array
	 * @access public
	 */
	public $outgoing_headers = array();
	/**
	 * HTTP response
	 * @var string
	 * @access private
	 */
	public $response = '';
	/**
	 * SOAP headers for response (text or array of soapval or associative array)
	 * @var mixed
	 * @access public
	 */
	public $responseHeaders = '';
	/**
	 * SOAP payload for response (text)
	 * @var string
	 * @access private
	 */
	public $responseSOAP = '';
	/**
	 * method return value to place in response
	 * @var mixed
	 * @access private
	 */
	public $methodreturn = false;
	/**
	 * whether $methodreturn is a string of literal XML
	 * @var boolean
	 * @access public
	 */
	public $methodreturnisliteralxml = false;
	/**
	 * SOAP fault for response (or false)
	 * @var mixed
	 * @access private
	 */
	public $fault = false;
	/**
	 * text indication of result (for debugging)
	 * @var string
	 * @access private
	 */
	public $result = 'successful';
	/**
	 * assoc array of operations => opData; operations are added by the register()
	 * method or by parsing an external WSDL definition
	 * @var array
	 * @access private
	 */
	public $operations = array();
	/**
	 * wsdl instance (if one)
	 * @var mixed
	 * @access private
	 */
	public $wsdl = false;
	/**
	 * URL for WSDL (if one)
	 * @var mixed
	 * @access private
	 */
	public $externalWSDLURL = false;
	/**
	 * whether to append debug to response as XML comment
	 * @var boolean
	 * @access public
	 */
	public $debug_flag = false;
	/**
	 * Identification for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $title = 'NuSOAP';
	/**
	 * Version for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $version = '0.9.5';
	/**
	 * CVS revision for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $revision = '$Revision: 1.123 $';
	/**
     * Current error string (manipulated by getError/setError)
	 *
	 * @var string
	 * @access private
	 */
	public $error_str = '';
	/**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
	 *
	 * @var string
	 * @access private
	 */
	public $debug_str = '';
	/**
	 * toggles automatic encoding of special characters as entities
	 * (should always be true, I think)
	 *
	 * @var boolean
	 * @access private
	 */
	public $charencoding = true;
	/**
	 * the debug level for this instance
	 *
	 * @var	integer
	 * @access private
	 */
	public $debugLevel;
	/**
	* set schema version
	*
	* @var      string
	* @access   public
	*/
	public $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';
	/**
	* charset encoding for outgoing messages
	*
	* @var      string
	* @access   public
	*/
	public $soap_defencoding = 'ISO-8859-1';
	/**
	* namespaces in an array of prefix => uri
	*
	* this is "seeded" by a set of constants, but it may be altered by code
	*
	* @var      array
	* @access   public
	*/
	public $namespaces = array('SOAP-ENV' => 'http://schemas.xmlsoap.org/soap/envelope/', 'xsd' => 'http://www.w3.org/2001/XMLSchema', 'xsi' => 'http://www.w3.org/2001/XMLSchema-instance', 'SOAP-ENC' => 'http://schemas.xmlsoap.org/soap/encoding/');
	/**
	* namespaces used in the current context, e.g. during serialization
	*
	* @var      array
	* @access   private
	*/
	public $usedNamespaces = array();
	/**
	* XML Schema types in an array of uri => (array of xml type => php type)
	* is this legacy yet?
	* no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
	* @var      array
	* @access   public
	*/
	public $typemap = array(
		'http://www.w3.org/2001/XMLSchema'          => array('string' => 'string', 'boolean' => 'boolean', 'float' => 'double', 'double' => 'double', 'decimal' => 'double', 'duration' => '', 'dateTime' => 'string', 'time' => 'string', 'date' => 'string', 'gYearMonth' => '', 'gYear' => '', 'gMonthDay' => '', 'gDay' => '', 'gMonth' => '', 'hexBinary' => 'string', 'base64Binary' => 'string', 'anyType' => 'string', 'anySimpleType' => 'string', 'normalizedString' => 'string', 'token' => 'string', 'language' => '', 'NMTOKEN' => '', 'NMTOKENS' => '', 'Name' => '', 'NCName' => '', 'ID' => '', 'IDREF' => '', 'IDREFS' => '', 'ENTITY' => '', 'ENTITIES' => '', 'integer' => 'integer', 'nonPositiveInteger' => 'integer', 'negativeInteger' => 'integer', 'long' => 'integer', 'int' => 'integer', 'short' => 'integer', 'byte' => 'integer', 'nonNegativeInteger' => 'integer', 'unsignedLong' => '', 'unsignedInt' => '', 'unsignedShort' => '', 'unsignedByte' => '', 'positiveInteger' => ''),
		'http://www.w3.org/2000/10/XMLSchema'       => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://www.w3.org/1999/XMLSchema'          => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://soapinterop.org/xsd'                => array('SOAPStruct' => 'struct'),
		'http://schemas.xmlsoap.org/soap/encoding/' => array('base64' => 'string', 'array' => 'array', 'Array' => 'array'),
		'http://xml.apache.org/xml-soap'            => array('Map')
		);
	/**
	* XML entities to convert
	*
	* @var      array
	* @access   public
	* @deprecated
	* @see	expandEntities
	*/
	public $xmlEntities = array('quot' => '"', 'amp' => '&', 'lt' => '<', 'gt' => '>', 'apos' => '\'');

	/**
	* constructor
    * the optional parameter is a path to a WSDL file that you'd like to bind the server instance to.
	*
    * @param mixed $wsdl file path or URL (string), or wsdl instance (object)
	* @access   public
	*/
	public function nusoap_server($wsdl = false)
	{
		parent::nusoap_base();
		global $debug;
		global $HTTP_SERVER_VARS;

		if (isset($_SERVER)) {
			$this->debug('_SERVER is defined:');
			$this->appendDebug($this->varDump($_SERVER));
		}
		else if (isset($HTTP_SERVER_VARS)) {
			$this->debug('HTTP_SERVER_VARS is defined:');
			$this->appendDebug($this->varDump($HTTP_SERVER_VARS));
		}
		else {
			$this->debug('Neither _SERVER nor HTTP_SERVER_VARS is defined.');
		}

		if (isset($debug)) {
			$this->debug('In nusoap_server, set debug_flag=' . $debug . ' based on global flag');
			$this->debug_flag = $debug;
		}
		else if (isset($_SERVER['QUERY_STRING'])) {
			$qs = explode('&', $_SERVER['QUERY_STRING']);

			foreach ($qs as $v) {
				if (substr($v, 0, 6) == 'debug=') {
					$this->debug('In nusoap_server, set debug_flag=' . substr($v, 6) . ' based on query string #1');
					$this->debug_flag = substr($v, 6);
				}
			}
		}
		else {
			if (isset($HTTP_SERVER_VARS['QUERY_STRING'])) {
				$qs = explode('&', $HTTP_SERVER_VARS['QUERY_STRING']);

				foreach ($qs as $v) {
					if (substr($v, 0, 6) == 'debug=') {
						$this->debug('In nusoap_server, set debug_flag=' . substr($v, 6) . ' based on query string #2');
						$this->debug_flag = substr($v, 6);
					}
				}
			}
		}

		if ($wsdl) {
			$this->debug('In nusoap_server, WSDL is specified');
			if (is_object($wsdl) && get_class($wsdl) == 'wsdl') {
				$this->wsdl = $wsdl;
				$this->externalWSDLURL = $this->wsdl->wsdl;
				$this->debug('Use existing wsdl instance from ' . $this->externalWSDLURL);
			}
			else {
				$this->debug('Create wsdl from ' . $wsdl);
				$this->wsdl = new wsdl($wsdl);
				$this->externalWSDLURL = $wsdl;
			}

			$this->appendDebug($this->wsdl->getDebug());
			$this->wsdl->clearDebug();

			if ($err = $this->wsdl->getError()) {
				exit('WSDL ERROR: ' . $err);
			}
		}
	}

	/**
	* processes request and returns response
	*
	* @param    string $data usually is the value of $HTTP_RAW_POST_DATA
	* @access   public
	*/
	public function service($data)
	{
		global $HTTP_SERVER_VARS;

		if (isset($_SERVER['REQUEST_METHOD'])) {
			$rm = $_SERVER['REQUEST_METHOD'];
		}
		else if (isset($HTTP_SERVER_VARS['REQUEST_METHOD'])) {
			$rm = $HTTP_SERVER_VARS['REQUEST_METHOD'];
		}
		else {
			$rm = '';
		}

		if (isset($_SERVER['QUERY_STRING'])) {
			$qs = $_SERVER['QUERY_STRING'];
		}
		else if (isset($HTTP_SERVER_VARS['QUERY_STRING'])) {
			$qs = $HTTP_SERVER_VARS['QUERY_STRING'];
		}
		else {
			$qs = '';
		}

		$this->debug('In service, request method=' . $rm . ' query string=' . $qs . ' strlen($data)=' . strlen($data));

		if ($rm == 'POST') {
			$this->debug('In service, invoke the request');
			$this->parse_request($data);

			if (!$this->fault) {
				$this->invoke_method();
			}

			if (!$this->fault) {
				$this->serialize_return();
			}

			$this->send_response();
			return NULL;
		}

		if (preg_match('/wsdl/', $qs)) {
			$this->debug('In service, this is a request for WSDL');

			if ($this->externalWSDLURL) {
				if (strpos($this->externalWSDLURL, 'http://') !== false) {
					$this->debug('In service, re-direct for WSDL');
					header('Location: ' . $this->externalWSDLURL);
					return NULL;
				}

				$this->debug('In service, use file passthru for WSDL');
				header("Content-Type: text/xml\r\n");
				$pos = strpos($this->externalWSDLURL, 'file://');

				if ($pos === false) {
					$filename = $this->externalWSDLURL;
				}
				else {
					$filename = substr($this->externalWSDLURL, $pos + 7);
				}

				$fp = fopen($this->externalWSDLURL, 'r');
				fpassthru($fp);
				return NULL;
			}

			if ($this->wsdl) {
				$this->debug('In service, serialize WSDL');
				header("Content-Type: text/xml; charset=ISO-8859-1\r\n");
				print($this->wsdl->serialize($this->debug_flag));

				if ($this->debug_flag) {
					$this->debug('wsdl:');
					$this->appendDebug($this->varDump($this->wsdl));
					print($this->getDebugAsXMLComment());
					return NULL;
				}
			}
			else {
				$this->debug('In service, there is no WSDL');
				header("Content-Type: text/html; charset=ISO-8859-1\r\n");
				print('This service does not provide WSDL');
				return NULL;
			}
		}
		else {
			if ($this->wsdl) {
				$this->debug('In service, return Web description');
				print($this->wsdl->webDescription());
				return NULL;
			}

			$this->debug('In service, no Web description');
			header("Content-Type: text/html; charset=ISO-8859-1\r\n");
			print('This service does not provide a Web description');
		}
	}

	/**
	* parses HTTP request headers.
	*
	* The following fields are set by this function (when successful)
	*
	* headers
	* request
	* xml_encoding
	* SOAPAction
	*
	* @access   private
	*/
	public function parse_http_headers()
	{
		global $HTTP_SERVER_VARS;
		$this->request = '';
		$this->SOAPAction = '';

		if (function_exists('getallheaders')) {
			$this->debug('In parse_http_headers, use getallheaders');
			$headers = getallheaders();

			foreach ($headers as $k => $v) {
				$k = strtolower($k);
				$this->headers[$k] = $v;
				$this->request .= $k . ': ' . $v . "\r\n";
				$this->debug($k . ': ' . $v);
			}

			if (isset($this->headers['soapaction'])) {
				$this->SOAPAction = str_replace('"', '', $this->headers['soapaction']);
			}

			if (isset($this->headers['content-type']) && strpos($this->headers['content-type'], '=')) {
				$enc = str_replace('"', '', substr(strstr($this->headers['content-type'], '='), 1));

				if (preg_match('/^(ISO-8859-1|US-ASCII|UTF-8)$/i', $enc)) {
					$this->xml_encoding = strtoupper($enc);
					return NULL;
				}

				$this->xml_encoding = 'US-ASCII';
				return NULL;
			}

			$this->xml_encoding = 'ISO-8859-1';
			return NULL;
		}

		if (isset($_SERVER) && is_array($_SERVER)) {
			$this->debug('In parse_http_headers, use _SERVER');

			foreach ($_SERVER as $k => $v) {
				if (substr($k, 0, 5) == 'HTTP_') {
					$k = str_replace(' ', '-', strtolower(str_replace('_', ' ', substr($k, 5))));
				}
				else {
					$k = str_replace(' ', '-', strtolower(str_replace('_', ' ', $k)));
				}

				if ($k == 'soapaction') {
					$k = 'SOAPAction';
					$v = str_replace('"', '', $v);
					$v = str_replace('\\', '', $v);
					$this->SOAPAction = $v;
				}
				else {
					if ($k == 'content-type') {
						if (strpos($v, '=')) {
							$enc = substr(strstr($v, '='), 1);
							$enc = str_replace('"', '', $enc);
							$enc = str_replace('\\', '', $enc);

							if (preg_match('/^(ISO-8859-1|US-ASCII|UTF-8)$/i', $enc)) {
								$this->xml_encoding = strtoupper($enc);
							}
							else {
								$this->xml_encoding = 'US-ASCII';
							}
						}
						else {
							$this->xml_encoding = 'ISO-8859-1';
						}
					}
				}

				$this->headers[$k] = $v;
				$this->request .= $k . ': ' . $v . "\r\n";
				$this->debug($k . ': ' . $v);
			}

			return NULL;
		}

		if (is_array($HTTP_SERVER_VARS)) {
			$this->debug('In parse_http_headers, use HTTP_SERVER_VARS');

			foreach ($HTTP_SERVER_VARS as $k => $v) {
				if (substr($k, 0, 5) == 'HTTP_') {
					$k = str_replace(' ', '-', strtolower(str_replace('_', ' ', substr($k, 5))));
					$k = strtolower(substr($k, 5));
				}
				else {
					$k = str_replace(' ', '-', strtolower(str_replace('_', ' ', $k)));
					$k = strtolower($k);
				}

				if ($k == 'soapaction') {
					$k = 'SOAPAction';
					$v = str_replace('"', '', $v);
					$v = str_replace('\\', '', $v);
					$this->SOAPAction = $v;
				}
				else {
					if ($k == 'content-type') {
						if (strpos($v, '=')) {
							$enc = substr(strstr($v, '='), 1);
							$enc = str_replace('"', '', $enc);
							$enc = str_replace('\\', '', $enc);

							if (preg_match('/^(ISO-8859-1|US-ASCII|UTF-8)$/i', $enc)) {
								$this->xml_encoding = strtoupper($enc);
							}
							else {
								$this->xml_encoding = 'US-ASCII';
							}
						}
						else {
							$this->xml_encoding = 'ISO-8859-1';
						}
					}
				}

				$this->headers[$k] = $v;
				$this->request .= $k . ': ' . $v . "\r\n";
				$this->debug($k . ': ' . $v);
			}

			return NULL;
		}

		$this->debug('In parse_http_headers, HTTP headers not accessible');
		$this->setError('HTTP headers not accessible');
	}

	/**
	* parses a request
	*
	* The following fields are set by this function (when successful)
	*
	* headers
	* request
	* xml_encoding
	* SOAPAction
	* request
	* requestSOAP
	* methodURI
	* methodname
	* methodparams
	* requestHeaders
	* document
	*
	* This sets the fault field on error
	*
	* @param    string $data XML string
	* @access   private
	*/
	public function parse_request($data = '')
	{
		$this->debug('entering parse_request()');
		$this->parse_http_headers();
		$this->debug('got character encoding: ' . $this->xml_encoding);
		if (isset($this->headers['content-encoding']) && $this->headers['content-encoding'] != '') {
			$this->debug('got content encoding: ' . $this->headers['content-encoding']);
			if ($this->headers['content-encoding'] == 'deflate' || $this->headers['content-encoding'] == 'gzip') {
				if (function_exists('gzuncompress')) {
					if ($this->headers['content-encoding'] == 'deflate' && ($degzdata = @gzuncompress($data))) {
						$data = $degzdata;
					}
					else {
						if ($this->headers['content-encoding'] == 'gzip' && ($degzdata = gzinflate(substr($data, 10)))) {
							$data = $degzdata;
						}
						else {
							$this->fault('SOAP-ENV:Client', 'Errors occurred when trying to decode the data');
							return NULL;
						}
					}
				}
				else {
					$this->fault('SOAP-ENV:Client', 'This Server does not support compressed data');
					return NULL;
				}
			}
		}

		$this->request .= "\r\n" . $data;
		$data = $this->parseRequest($this->headers, $data);
		$this->requestSOAP = $data;
		$this->debug('leaving parse_request');
	}

	/**
	* invokes a PHP function for the requested SOAP method
	*
	* The following fields are set by this function (when successful)
	*
	* methodreturn
	*
	* Note that the PHP function that is called may also set the following
	* fields to affect the response sent to the client
	*
	* responseHeaders
	* outgoing_headers
	*
	* This sets the fault field on error
	*
	* @access   private
	*/
	public function invoke_method()
	{
		$this->debug('in invoke_method, methodname=' . $this->methodname . ' methodURI=' . $this->methodURI . ' SOAPAction=' . $this->SOAPAction);
		$orig_methodname = $this->methodname;

		if ($this->wsdl) {
			if ($this->opData = $this->wsdl->getOperationData($this->methodname)) {
				$this->debug('in invoke_method, found WSDL operation=' . $this->methodname);
				$this->appendDebug('opData=' . $this->varDump($this->opData));
			}
			else if ($this->opData = $this->wsdl->getOperationDataForSoapAction($this->SOAPAction)) {
				$this->debug('in invoke_method, found WSDL soapAction=' . $this->SOAPAction . ' for operation=' . $this->opData['name']);
				$this->appendDebug('opData=' . $this->varDump($this->opData));
				$this->methodname = $this->opData['name'];
			}
			else {
				$this->debug('in invoke_method, no WSDL for operation=' . $this->methodname);
				$this->fault('SOAP-ENV:Client', 'Operation \'' . $this->methodname . '\' is not defined in the WSDL for this service');
				return NULL;
			}
		}
		else {
			$this->debug('in invoke_method, no WSDL to validate method');
		}

		if (0 < strpos($this->methodname, '..')) {
			$delim = '..';
		}
		else if (0 < strpos($this->methodname, '.')) {
			$delim = '.';
		}
		else {
			$delim = '';
		}

		$this->debug('in invoke_method, delim=' . $delim);
		$class = '';
		$method = '';
		if (0 < strlen($delim) && substr_count($this->methodname, $delim) == 1) {
			$try_class = substr($this->methodname, 0, strpos($this->methodname, $delim));

			if (class_exists($try_class)) {
				$class = $try_class;
				$method = substr($this->methodname, strpos($this->methodname, $delim) + strlen($delim));
				$this->debug('in invoke_method, class=' . $class . ' method=' . $method . ' delim=' . $delim);
			}
			else {
				$this->debug('in invoke_method, class=' . $try_class . ' not found');
			}
		}
		else {
			$try_class = '';
			$this->debug('in invoke_method, no class to try');
		}

		if ($class == '') {
			if (!function_exists($this->methodname)) {
				$this->debug('in invoke_method, function \'' . $this->methodname . '\' not found!');
				$this->result = 'fault: method not found';
				$this->fault('SOAP-ENV:Client', 'method \'' . $this->methodname . '\'(\'' . $orig_methodname . '\') not defined in service(\'' . $try_class . '\' \'' . $delim . '\')');
				return NULL;
			}
		}
		else {
			$method_to_compare = substr(phpversion(), 0, 2) == '4.' ? strtolower($method) : $method;

			if (!in_array($method_to_compare, get_class_methods($class))) {
				$this->debug('in invoke_method, method \'' . $this->methodname . '\' not found in class \'' . $class . '\'!');
				$this->result = 'fault: method not found';
				$this->fault('SOAP-ENV:Client', 'method \'' . $this->methodname . '\'/\'' . $method_to_compare . '\'(\'' . $orig_methodname . '\') not defined in service/\'' . $class . '\'(\'' . $try_class . '\' \'' . $delim . '\')');
				return NULL;
			}
		}

		if (!$this->verify_method($this->methodname, $this->methodparams)) {
			$this->debug('ERROR: request not verified against method signature');
			$this->result = 'fault: request failed validation against method signature';
			$this->fault('SOAP-ENV:Client', 'Operation \'' . $this->methodname . '\' not defined in service.');
			return NULL;
		}

		$this->debug('in invoke_method, params:');
		$this->appendDebug($this->varDump($this->methodparams));
		$this->debug('in invoke_method, calling \'' . $this->methodname . '\'');

		if (!function_exists('call_user_func_array')) {
			if ($class == '') {
				$this->debug('in invoke_method, calling function using eval()');
				$funcCall = '$this->methodreturn = ' . $this->methodname . '(';
			}
			else if ($delim == '..') {
				$this->debug('in invoke_method, calling class method using eval()');
				$funcCall = '$this->methodreturn = ' . $class . '::' . $method . '(';
			}
			else {
				$this->debug('in invoke_method, calling instance method using eval()');
				$instname = '$inst_' . time();
				$funcCall = $instname . ' = new ' . $class . '(); ';
				$funcCall .= '$this->methodreturn = ' . $instname . '->' . $method . '(';
			}

			if ($this->methodparams) {
				foreach ($this->methodparams as $param) {
					if (is_array($param) || is_object($param)) {
						$this->fault('SOAP-ENV:Client', 'NuSOAP does not handle complexType parameters correctly when using eval; call_user_func_array must be available');
						return NULL;
					}

					$funcCall .= '"' . $param . '",';
				}

				$funcCall = substr($funcCall, 0, -1);
			}

			$funcCall .= ');';
			$this->debug('in invoke_method, function call: ' . $funcCall);
			@eval ($funcCall);
		}
		else {
			if ($class == '') {
				$this->debug('in invoke_method, calling function using call_user_func_array()');
				$call_arg = $this->methodname;
			}
			else if ($delim == '..') {
				$this->debug('in invoke_method, calling class method using call_user_func_array()');
				$call_arg = array($class, $method);
			}
			else {
				$this->debug('in invoke_method, calling instance method using call_user_func_array()');
				$instance = new $class();
				$call_arg = array(&$instance, $method);
			}

			if (is_array($this->methodparams)) {
				$this->methodreturn = call_user_func_array($call_arg, array_values($this->methodparams));
			}
			else {
				$this->methodreturn = call_user_func_array($call_arg, array());
			}
		}

		$this->debug('in invoke_method, methodreturn:');
		$this->appendDebug($this->varDump($this->methodreturn));
		$this->debug('in invoke_method, called method ' . $this->methodname . ', received data of type ' . gettype($this->methodreturn));
	}

	/**
	* serializes the return value from a PHP function into a full SOAP Envelope
	*
	* The following fields are set by this function (when successful)
	*
	* responseSOAP
	*
	* This sets the fault field on error
	*
	* @access   private
	*/
	public function serialize_return()
	{
		$this->debug('Entering serialize_return methodname: ' . $this->methodname . ' methodURI: ' . $this->methodURI);
		if (isset($this->methodreturn) && is_object($this->methodreturn) && (get_class($this->methodreturn) == 'soap_fault' || get_class($this->methodreturn) == 'nusoap_fault')) {
			$this->debug('got a fault object from method');
			$this->fault = $this->methodreturn;
			return NULL;
		}

		if ($this->methodreturnisliteralxml) {
			$return_val = $this->methodreturn;
		}
		else {
			$this->debug('got a(n) ' . gettype($this->methodreturn) . ' from method');
			$this->debug('serializing return value');

			if ($this->wsdl) {
				if (1 < sizeof($this->opData['output']['parts'])) {
					$this->debug('more than one output part, so use the method return unchanged');
					$opParams = $this->methodreturn;
				}
				else {
					if (sizeof($this->opData['output']['parts']) == 1) {
						$this->debug('exactly one output part, so wrap the method return in a simple array');
						$opParams = array($this->methodreturn);
					}
				}

				$return_val = $this->wsdl->serializeRPCParameters($this->methodname, 'output', $opParams);
				$this->appendDebug($this->wsdl->getDebug());
				$this->wsdl->clearDebug();

				if ($errstr = $this->wsdl->getError()) {
					$this->debug('got wsdl error: ' . $errstr);
					$this->fault('SOAP-ENV:Server', 'unable to serialize result');
					return NULL;
				}
			}
			else if (isset($this->methodreturn)) {
				$return_val = $this->serialize_val($this->methodreturn, 'return');
			}
			else {
				$return_val = '';
				$this->debug('in absence of WSDL, assume void return for backward compatibility');
			}
		}

		$this->debug('return value:');
		$this->appendDebug($this->varDump($return_val));
		$this->debug('serializing response');

		if ($this->wsdl) {
			$this->debug('have WSDL for serialization: style is ' . $this->opData['style']);

			if ($this->opData['style'] == 'rpc') {
				$this->debug('style is rpc for serialization: use is ' . $this->opData['output']['use']);

				if ($this->opData['output']['use'] == 'literal') {
					if ($this->methodURI) {
						$payload = '<ns1:' . $this->methodname . 'Response xmlns:ns1="' . $this->methodURI . '">' . $return_val . '</ns1:' . $this->methodname . 'Response>';
					}
					else {
						$payload = '<' . $this->methodname . 'Response>' . $return_val . '</' . $this->methodname . 'Response>';
					}
				}
				else if ($this->methodURI) {
					$payload = '<ns1:' . $this->methodname . 'Response xmlns:ns1="' . $this->methodURI . '">' . $return_val . '</ns1:' . $this->methodname . 'Response>';
				}
				else {
					$payload = '<' . $this->methodname . 'Response>' . $return_val . '</' . $this->methodname . 'Response>';
				}
			}
			else {
				$this->debug('style is not rpc for serialization: assume document');
				$payload = $return_val;
			}
		}
		else {
			$this->debug('do not have WSDL for serialization: assume rpc/encoded');
			$payload = '<ns1:' . $this->methodname . 'Response xmlns:ns1="' . $this->methodURI . '">' . $return_val . '</ns1:' . $this->methodname . 'Response>';
		}

		$this->result = 'successful';

		if ($this->wsdl) {
			$this->appendDebug($this->wsdl->getDebug());

			if (isset($this->opData['output']['encodingStyle'])) {
				$encodingStyle = $this->opData['output']['encodingStyle'];
			}
			else {
				$encodingStyle = '';
			}

			$this->responseSOAP = $this->serializeEnvelope($payload, $this->responseHeaders, $this->wsdl->usedNamespaces, $this->opData['style'], $this->opData['output']['use'], $encodingStyle);
		}
		else {
			$this->responseSOAP = $this->serializeEnvelope($payload, $this->responseHeaders);
		}

		$this->debug('Leaving serialize_return');
	}

	/**
	* sends an HTTP response
	*
	* The following fields are set by this function (when successful)
	*
	* outgoing_headers
	* response
	*
	* @access   private
	*/
	public function send_response()
	{
		$this->debug('Enter send_response');

		if ($this->fault) {
			$payload = $this->fault->serialize();
			$this->outgoing_headers[] = 'HTTP/1.0 500 Internal Server Error';
			$this->outgoing_headers[] = 'Status: 500 Internal Server Error';
		}
		else {
			$payload = $this->responseSOAP;
		}

		if (isset($this->debug_flag) && $this->debug_flag) {
			$payload .= $this->getDebugAsXMLComment();
		}

		$this->outgoing_headers[] = 'Server: ' . $this->title . ' Server v' . $this->version;
		preg_match('/\\$Revisio' . 'n: ([^ ]+)/', $this->revision, $rev);
		$this->outgoing_headers[] = 'X-SOAP-Server: ' . $this->title . '/' . $this->version . ' (' . $rev[1] . ')';
		$payload = $this->getHTTPBody($payload);
		$type = $this->getHTTPContentType();
		$charset = $this->getHTTPContentTypeCharset();
		$this->outgoing_headers[] = 'Content-Type: ' . $type . ($charset ? '; charset=' . $charset : '');
		if (1024 < strlen($payload) && isset($this->headers) && isset($this->headers['accept-encoding'])) {
			if (strstr($this->headers['accept-encoding'], 'gzip')) {
				if (function_exists('gzencode')) {
					if (isset($this->debug_flag) && $this->debug_flag) {
						$payload .= '<!-- Content being gzipped -->';
					}

					$this->outgoing_headers[] = 'Content-Encoding: gzip';
					$payload = gzencode($payload);
				}
				else {
					if (isset($this->debug_flag) && $this->debug_flag) {
						$payload .= '<!-- Content will not be gzipped: no gzencode -->';
					}
				}
			}
			else {
				if (strstr($this->headers['accept-encoding'], 'deflate')) {
					if (function_exists('gzdeflate')) {
						if (isset($this->debug_flag) && $this->debug_flag) {
							$payload .= '<!-- Content being deflated -->';
						}

						$this->outgoing_headers[] = 'Content-Encoding: deflate';
						$payload = gzdeflate($payload);
					}
					else {
						if (isset($this->debug_flag) && $this->debug_flag) {
							$payload .= '<!-- Content will not be deflated: no gzcompress -->';
						}
					}
				}
			}
		}

		$this->outgoing_headers[] = 'Content-Length: ' . strlen($payload);
		reset($this->outgoing_headers);

		foreach ($this->outgoing_headers as $hdr) {
			header($hdr, false);
		}

		print($payload);
		$this->response = join("\r\n", $this->outgoing_headers) . "\r\n\r\n" . $payload;
	}

	/**
	* takes the value that was created by parsing the request
	* and compares to the method's signature, if available.
	*
	* @param	string	$operation	The operation to be invoked
	* @param	array	$request	The array of parameter values
	* @return	boolean	Whether the operation was found
	* @access   private
	*/
	public function verify_method($operation, $request)
	{
		if (isset($this->wsdl) && is_object($this->wsdl)) {
			if ($this->wsdl->getOperationData($operation)) {
				return true;
			}
		}
		else {
			if (isset($this->operations[$operation])) {
				return true;
			}
		}

		return false;
	}

	/**
	* processes SOAP message received from client
	*
	* @param	array	$headers	The HTTP headers
	* @param	string	$data		unprocessed request data from client
	* @return	mixed	value of the message, decoded into a PHP type
	* @access   private
	*/
	public function parseRequest($headers, $data)
	{
		$this->debug('Entering parseRequest() for data of length ' . strlen($data) . ' headers:');
		$this->appendDebug($this->varDump($headers));

		if (!isset($headers['content-type'])) {
			$this->setError('Request not of type text/xml (no content-type header)');
			return false;
		}

		if (!strstr($headers['content-type'], 'text/xml')) {
			$this->setError('Request not of type text/xml');
			return false;
		}

		if (strpos($headers['content-type'], '=')) {
			$enc = str_replace('"', '', substr(strstr($headers['content-type'], '='), 1));
			$this->debug('Got response encoding: ' . $enc);

			if (preg_match('/^(ISO-8859-1|US-ASCII|UTF-8)$/i', $enc)) {
				$this->xml_encoding = strtoupper($enc);
			}
			else {
				$this->xml_encoding = 'US-ASCII';
			}
		}
		else {
			$this->xml_encoding = 'ISO-8859-1';
		}

		$this->debug('Use encoding: ' . $this->xml_encoding . ' when creating nusoap_parser');
		$parser = new nusoap_parser($data, $this->xml_encoding, '', $this->decode_utf8);
		$this->debug("parser debug: \n" . $parser->getDebug());

		if ($err = $parser->getError()) {
			$this->result = 'fault: error in msg parsing: ' . $err;
			$this->fault('SOAP-ENV:Client', "error in msg parsing:\n" . $err);
			return NULL;
		}

		$this->methodURI = $parser->root_struct_namespace;
		$this->methodname = $parser->root_struct_name;
		$this->debug('methodname: ' . $this->methodname . ' methodURI: ' . $this->methodURI);
		$this->debug('calling parser->get_soapbody()');
		$this->methodparams = $parser->get_soapbody();
		$this->requestHeaders = $parser->getHeaders();
		$this->requestHeader = $parser->get_soapheader();
		$this->document = $parser->document;
	}

	/**
	* gets the HTTP body for the current response.
	*
	* @param string $soapmsg The SOAP payload
	* @return string The HTTP body, which includes the SOAP payload
	* @access private
	*/
	public function getHTTPBody($soapmsg)
	{
		return $soapmsg;
	}

	/**
	* gets the HTTP content type for the current response.
	*
	* Note: getHTTPBody must be called before this.
	*
	* @return string the HTTP content type for the current response.
	* @access private
	*/
	public function getHTTPContentType()
	{
		return 'text/xml';
	}

	/**
	* gets the HTTP content type charset for the current response.
	* returns false for non-text content types.
	*
	* Note: getHTTPBody must be called before this.
	*
	* @return string the HTTP content type charset for the current response.
	* @access private
	*/
	public function getHTTPContentTypeCharset()
	{
		return $this->soap_defencoding;
	}

	/**
	* add a method to the dispatch map (this has been replaced by the register method)
	*
	* @param    string $methodname
	* @param    string $in array of input values
	* @param    string $out array of output values
	* @access   public
	* @deprecated
	*/
	public function add_to_map($methodname, $in, $out)
	{
		$this->operations[$methodname] = array('name' => $methodname, 'in' => $in, 'out' => $out);
	}

	/**
	* register a service function with the server
	*
	* @param    string $name the name of the PHP function, class.method or class..method
	* @param    array $in assoc array of input values: key = param name, value = param type
	* @param    array $out assoc array of output values: key = param name, value = param type
	* @param	mixed $namespace the element namespace for the method or false
	* @param	mixed $soapaction the soapaction for the method or false
	* @param	mixed $style optional (rpc|document) or false Note: when 'document' is specified, parameter and return wrappers are created for you automatically
	* @param	mixed $use optional (encoded|literal) or false
	* @param	string $documentation optional Description to include in WSDL
	* @param	string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
	* @access   public
	*/
	public function register($name, $in = array(), $out = array(), $namespace = false, $soapaction = false, $style = false, $use = false, $documentation = '', $encodingStyle = '')
	{
		global $HTTP_SERVER_VARS;

		if ($this->externalWSDLURL) {
			exit('You cannot bind to an external WSDL file, and register methods outside of it! Please choose either WSDL or no WSDL.');
		}

		if (!$name) {
			exit('You must specify a name when you register an operation');
		}

		if (!is_array($in)) {
			exit('You must provide an array for operation inputs');
		}

		if (!is_array($out)) {
			exit('You must provide an array for operation outputs');
		}

		if (false == $namespace) {
		}

		if (false == $soapaction) {
			if (isset($_SERVER)) {
				$SERVER_NAME = $_SERVER['SERVER_NAME'];
				$SCRIPT_NAME = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
				$HTTPS = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : (isset($HTTP_SERVER_VARS['HTTPS']) ? $HTTP_SERVER_VARS['HTTPS'] : 'off');
			}
			else if (isset($HTTP_SERVER_VARS)) {
				$SERVER_NAME = $HTTP_SERVER_VARS['SERVER_NAME'];
				$SCRIPT_NAME = isset($HTTP_SERVER_VARS['PHP_SELF']) ? $HTTP_SERVER_VARS['PHP_SELF'] : $HTTP_SERVER_VARS['SCRIPT_NAME'];
				$HTTPS = isset($HTTP_SERVER_VARS['HTTPS']) ? $HTTP_SERVER_VARS['HTTPS'] : 'off';
			}
			else {
				$this->setError('Neither _SERVER nor HTTP_SERVER_VARS is available');
			}

			if ($HTTPS == '1' || $HTTPS == 'on') {
				$SCHEME = 'https';
			}
			else {
				$SCHEME = 'http';
			}

			$soapaction = $SCHEME . '://' . $SERVER_NAME . $SCRIPT_NAME . '/' . $name;
		}

		if (false == $style) {
			$style = 'rpc';
		}

		if (false == $use) {
			$use = 'encoded';
		}

		if ($use == 'encoded' && $encodingStyle == '') {
			$encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/';
		}

		$this->operations[$name] = array('name' => $name, 'in' => $in, 'out' => $out, 'namespace' => $namespace, 'soapaction' => $soapaction, 'style' => $style);

		if ($this->wsdl) {
			$this->wsdl->addOperation($name, $in, $out, $namespace, $soapaction, $style, $use, $documentation, $encodingStyle);
		}

		return true;
	}

	/**
	* Specify a fault to be returned to the client.
	* This also acts as a flag to the server that a fault has occured.
	*
	* @param	string $faultcode
	* @param	string $faultstring
	* @param	string $faultactor
	* @param	string $faultdetail
	* @access   public
	*/
	public function fault($faultcode, $faultstring, $faultactor = '', $faultdetail = '')
	{
		if ($faultdetail == '' && $this->debug_flag) {
			$faultdetail = $this->getDebug();
		}

		$this->fault = new nusoap_fault($faultcode, $faultactor, $faultstring, $faultdetail);
		$this->fault->soap_defencoding = $this->soap_defencoding;
	}

	/**
    * Sets up wsdl object.
    * Acts as a flag to enable internal WSDL generation
    *
    * @param string $serviceName, name of the service
    * @param mixed $namespace optional 'tns' service namespace or false
    * @param mixed $endpoint optional URL of service endpoint or false
    * @param string $style optional (rpc|document) WSDL style (also specified by operation)
    * @param string $transport optional SOAP transport
    * @param mixed $schemaTargetNamespace optional 'types' targetNamespace for service schema or false
    */
	public function configureWSDL($serviceName, $namespace = false, $endpoint = false, $style = 'rpc', $transport = 'http://schemas.xmlsoap.org/soap/http', $schemaTargetNamespace = false)
	{
		global $HTTP_SERVER_VARS;

		if (isset($_SERVER)) {
			$SERVER_NAME = $_SERVER['SERVER_NAME'];
			$SERVER_PORT = $_SERVER['SERVER_PORT'];
			$SCRIPT_NAME = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
			$HTTPS = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : (isset($HTTP_SERVER_VARS['HTTPS']) ? $HTTP_SERVER_VARS['HTTPS'] : 'off');
		}
		else if (isset($HTTP_SERVER_VARS)) {
			$SERVER_NAME = $HTTP_SERVER_VARS['SERVER_NAME'];
			$SERVER_PORT = $HTTP_SERVER_VARS['SERVER_PORT'];
			$SCRIPT_NAME = isset($HTTP_SERVER_VARS['PHP_SELF']) ? $HTTP_SERVER_VARS['PHP_SELF'] : $HTTP_SERVER_VARS['SCRIPT_NAME'];
			$HTTPS = isset($HTTP_SERVER_VARS['HTTPS']) ? $HTTP_SERVER_VARS['HTTPS'] : 'off';
		}
		else {
			$this->setError('Neither _SERVER nor HTTP_SERVER_VARS is available');
		}

		$colon = strpos($SERVER_NAME, ':');

		if ($colon) {
			$SERVER_NAME = substr($SERVER_NAME, 0, $colon);
		}

		if ($SERVER_PORT == 80) {
			$SERVER_PORT = '';
		}
		else {
			$SERVER_PORT = ':' . $SERVER_PORT;
		}

		if (false == $namespace) {
			$namespace = 'http://' . $SERVER_NAME . '/soap/' . $serviceName;
		}

		if (false == $endpoint) {
			if ($HTTPS == '1' || $HTTPS == 'on') {
				$SCHEME = 'https';
			}
			else {
				$SCHEME = 'http';
			}

			$endpoint = $SCHEME . '://' . $SERVER_NAME . $SERVER_PORT . $SCRIPT_NAME;
		}

		if (false == $schemaTargetNamespace) {
			$schemaTargetNamespace = $namespace;
		}

		$this->wsdl = new wsdl();
		$this->wsdl->serviceName = $serviceName;
		$this->wsdl->endpoint = $endpoint;
		$this->wsdl->namespaces['tns'] = $namespace;
		$this->wsdl->namespaces['soap'] = 'http://schemas.xmlsoap.org/wsdl/soap/';
		$this->wsdl->namespaces['wsdl'] = 'http://schemas.xmlsoap.org/wsdl/';

		if ($schemaTargetNamespace != $namespace) {
			$this->wsdl->namespaces['types'] = $schemaTargetNamespace;
		}

		$this->wsdl->schemas[$schemaTargetNamespace][0] = new nusoap_xmlschema('', '', $this->wsdl->namespaces);

		if ($style == 'document') {
			$this->wsdl->schemas[$schemaTargetNamespace][0]->schemaInfo['elementFormDefault'] = 'qualified';
		}

		$this->wsdl->schemas[$schemaTargetNamespace][0]->schemaTargetNamespace = $schemaTargetNamespace;
		$this->wsdl->schemas[$schemaTargetNamespace][0]->imports['http://schemas.xmlsoap.org/soap/encoding/'][0] = array('location' => '', 'loaded' => true);
		$this->wsdl->schemas[$schemaTargetNamespace][0]->imports['http://schemas.xmlsoap.org/wsdl/'][0] = array('location' => '', 'loaded' => true);
		$this->wsdl->bindings[$serviceName . 'Binding'] = array('name' => $serviceName . 'Binding', 'style' => $style, 'transport' => $transport, 'portType' => $serviceName . 'PortType');
		$this->wsdl->ports[$serviceName . 'Port'] = array('binding' => $serviceName . 'Binding', 'location' => $endpoint, 'bindingType' => 'http://schemas.xmlsoap.org/wsdl/soap/');
	}

	/**
	* constructor
	*
	* @access	public
	*/
	public function nusoap_base()
	{
		$this->debugLevel = $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* gets the global debug level, which applies to future instances
	*
	* @return	integer	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getGlobalDebugLevel()
	{
		return $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* sets the global debug level, which applies to future instances
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setGlobalDebugLevel($level)
	{
		$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = $level;
	}

	/**
	* gets the debug level for this instance
	*
	* @return	int	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}

	/**
	* sets the debug level for this instance
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}

	/**
	* adds debug data to the instance debug string with formatting
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function debug($string)
	{
		if (0 < $this->debugLevel) {
			$this->appendDebug($this->getmicrotime() . ' ' . get_class($this) . (': ' . $string . "\n"));
		}
	}

	/**
	* adds debug data to the instance debug string without formatting
	*
	* @param    string $string debug data
	* @access   public
	*/
	public function appendDebug($string)
	{
		if (0 < $this->debugLevel) {
			$this->debug_str .= $string;
		}
	}

	/**
	* clears the current debug data for this instance
	*
	* @access   public
	*/
	public function clearDebug()
	{
		$this->debug_str = '';
	}

	/**
	* gets the current debug data for this instance
	*
	* @return   debug data
	* @access   public
	*/
	public function& getDebug()
	{
		return $this->debug_str;
	}

	/**
	* gets the current debug data for this instance as an XML comment
	* this may change the contents of the debug data
	*
	* @return   debug data as an XML comment
	* @access   public
	*/
	public function& getDebugAsXMLComment()
	{
		while (strpos($this->debug_str, '--')) {
			$this->debug_str = str_replace('--', '- -', $this->debug_str);
		}

		$ret = "<!--\n" . $this->debug_str . "\n-->";
		return $ret;
	}

	/**
	* expands entities, e.g. changes '<' to '&lt;'.
	*
	* @param	string	$val	The string in which to expand entities.
	* @access	private
	*/
	public function expandEntities($val)
	{
		if ($this->charencoding) {
			$val = str_replace('&', '&amp;', $val);
			$val = str_replace('\'', '&apos;', $val);
			$val = str_replace('"', '&quot;', $val);
			$val = str_replace('<', '&lt;', $val);
			$val = str_replace('>', '&gt;', $val);
		}

		return $val;
	}

	/**
	* returns error string if present
	*
	* @return   mixed error string or false
	* @access   public
	*/
	public function getError()
	{
		if ($this->error_str != '') {
			return $this->error_str;
		}

		return false;
	}

	/**
	* sets error string
	*
	* @return   boolean $string error string
	* @access   private
	*/
	public function setError($str)
	{
		$this->error_str = $str;
	}

	/**
	* detect if array is a simple array or a struct (associative array)
	*
	* @param	mixed	$val	The PHP array
	* @return	string	(arraySimple|arrayStruct)
	* @access	private
	*/
	public function isArraySimpleOrStruct($val)
	{
		$keyList = array_keys($val);

		foreach ($keyList as $keyListValue) {
			if (!is_int($keyListValue)) {
				return 'arrayStruct';
			}
		}

		return 'arraySimple';
	}

	/**
	* serializes PHP values in accordance w/ section 5. Type information is
	* not serialized if $use == 'literal'.
	*
	* @param	mixed	$val	The value to serialize
	* @param	string	$name	The name (local part) of the XML element
	* @param	string	$type	The XML schema type (local part) for the element
	* @param	string	$name_ns	The namespace for the name of the XML element
	* @param	string	$type_ns	The namespace for the type of the element
	* @param	array	$attributes	The attributes to serialize as name=>value pairs
	* @param	string	$use	The WSDL "use" (encoded|literal)
	* @param	boolean	$soapval	Whether this is called from soapval.
	* @return	string	The serialized element, possibly with child elements
    * @access	public
	*/
	public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = 'encoded', $soapval = false)
	{
		$this->debug('in serialize_val: name=' . $name . ', type=' . $type . ', name_ns=' . $name_ns . ', type_ns=' . $type_ns . ', use=' . $use . ', soapval=' . $soapval);
		$this->appendDebug('value=' . $this->varDump($val));
		$this->appendDebug('attributes=' . $this->varDump($attributes));
		if (is_object($val) && get_class($val) == 'soapval' && !$soapval) {
			$this->debug('serialize_val: serialize soapval');
			$xml = $val->serialize($use);
			$this->appendDebug($val->getDebug());
			$val->clearDebug();
			$this->debug('serialize_val of soapval returning ' . $xml);
			return $xml;
		}

		if (is_numeric($name)) {
			$name = '__numeric_' . $name;
		}
		else {
			if (!$name) {
				$name = 'noname';
			}
		}

		$xmlns = '';

		if ($name_ns) {
			$prefix = 'nu' . rand(1000, 9999);
			$name = $prefix . ':' . $name;
			$xmlns .= ' xmlns:' . $prefix . '="' . $name_ns . '"';
		}

		if ($type_ns != '' && $type_ns == $this->namespaces['xsd']) {
			$type_prefix = 'xsd';
		}
		else {
			if ($type_ns) {
				$type_prefix = 'ns' . rand(1000, 9999);
				$xmlns .= ' xmlns:' . $type_prefix . '="' . $type_ns . '"';
			}
		}

		$atts = '';

		if ($attributes) {
			foreach ($attributes as $k => $v) {
				$atts .= ' ' . $k . '="' . $this->expandEntities($v) . '"';
			}
		}

		if (is_null($val)) {
			$this->debug('serialize_val: serialize null');

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '/>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			$xml = '<' . $name . $xmlns . $type_str . $atts . ' xsi:nil="true"/>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		if ($type != '' && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
			$this->debug('serialize_val: serialize xsd built-in primitive type');

			if (is_bool($val)) {
				if ($type == 'boolean') {
					$val = $val ? 'true' : 'false';
				}
				else {
					if (!$val) {
						$val = 0;
					}
				}
			}
			else {
				if (is_string($val)) {
					$val = $this->expandEntities($val);
				}
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			$xml = '<' . $name . $xmlns . ' xsi:type="xsd:' . $type . '"' . $atts . '>' . $val . '</' . $name . '>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		$xml = '';
		switch (true) {
		case is_bool($val) || $type == 'boolean':
			$this->debug('serialize_val: serialize boolean');

			if ($type == 'boolean') {
				$val = $val ? 'true' : 'false';
			}
			else {
				if (!$val) {
					$val = 0;
				}
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:boolean"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_int($val) || is_long($val) || $type == 'int':
			$this->debug('serialize_val: serialize int');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:int"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_float($val) || is_double($val) || $type == 'float':
			$this->debug('serialize_val: serialize float');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:float"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_string($val) || $type == 'string':
			$this->debug('serialize_val: serialize string');
			$val = $this->expandEntities($val);

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:string"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_object($val):
			$this->debug('serialize_val: serialize object');

			if (get_class($val) == 'soapval') {
				$this->debug('serialize_val: serialize soapval object');
				$pXml = $val->serialize($use);
				$this->appendDebug($val->getDebug());
				$val->clearDebug();
			}
			else {
				if (!$name) {
					$name = get_class($val);
					$this->debug('In serialize_val, used class name ' . $name . ' as element name');
				}
				else {
					$this->debug('In serialize_val, do not override name ' . $name . ' for element name for class ' . get_class($val));
				}

				foreach (get_object_vars($val) as $k => $v) {
					$pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $pXml . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . $type_str . $atts . '>' . $pXml . '</' . $name . '>';
			}

			break;

		case is_array($val) || $type:
			$valueType = $this->isArraySimpleOrStruct($val);
			if ($valueType == 'arraySimple' || preg_match('/^ArrayOf/', $type)) {
				$this->debug('serialize_val: serialize array');
				$i = 0;
				if (is_array($val) && 0 < count($val)) {
					foreach ($val as $v) {
						if (is_object($v) && get_class($v) == 'soapval') {
							$tt_ns = $v->type_ns;
							$tt = $v->type;
						}
						else if (is_array($v)) {
							$tt = $this->isArraySimpleOrStruct($v);
						}
						else {
							$tt = gettype($v);
						}

						$array_types[$tt] = 1;
						$xml .= $this->serialize_val($v, 'item', false, false, false, false, $use);
						++$i;
					}

					if (1 < count($array_types)) {
						$array_typename = 'xsd:anyType';
					}
					else {
						if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
							if ($tt == 'integer') {
								$tt = 'int';
							}

							$array_typename = 'xsd:' . $tt;
						}
						else {
							if (isset($tt) && $tt == 'arraySimple') {
								$array_typename = 'SOAP-ENC:Array';
							}
							else {
								if (isset($tt) && $tt == 'arrayStruct') {
									$array_typename = 'unnamed_struct_use_soapval';
								}
								else {
									if ($tt_ns != '' && $tt_ns == $this->namespaces['xsd']) {
										$array_typename = 'xsd:' . $tt;
									}
									else if ($tt_ns) {
										$tt_prefix = 'ns' . rand(1000, 9999);
										$array_typename = $tt_prefix . ':' . $tt;
										$xmlns .= ' xmlns:' . $tt_prefix . '="' . $tt_ns . '"';
									}
									else {
										$array_typename = $tt;
									}
								}
							}
						}
					}

					$array_type = $i;

					if ($use == 'literal') {
						$type_str = '';
					}
					else {
						if (isset($type) && isset($type_prefix)) {
							$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
						}
						else {
							$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="' . $array_typename . ('[' . $array_type . ']"');
						}
					}
				}
				else if ($use == 'literal') {
					$type_str = '';
				}
				else {
					if (isset($type) && isset($type_prefix)) {
						$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
					}
					else {
						$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="xsd:anyType[0]"';
					}
				}

				$xml = '<' . $name . $xmlns . $type_str . $atts . '>' . $xml . ('</' . $name . '>');
			}
			else {
				$this->debug('serialize_val: serialize struct');
				if (isset($type) && isset($type_prefix)) {
					$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
				}
				else {
					$type_str = '';
				}

				if ($use == 'literal') {
					$xml .= '<' . $name . $xmlns . $atts . '>';
				}
				else {
					$xml .= '<' . $name . $xmlns . $type_str . $atts . '>';
				}

				foreach ($val as $k => $v) {
					if ($type == 'Map' && $type_ns == 'http://xml.apache.org/xml-soap') {
						$xml .= '<item>';
						$xml .= $this->serialize_val($k, 'key', false, false, false, false, $use);
						$xml .= $this->serialize_val($v, 'value', false, false, false, false, $use);
						$xml .= '</item>';
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$xml .= '</' . $name . '>';
			}

			break;

		default:
			$this->debug('serialize_val: serialize unknown');
			$xml .= 'not detected, got ' . gettype($val) . ' for ' . $val;
			break;
		}

		$this->debug('serialize_val returning ' . $xml);
		return $xml;
	}

	/**
    * serializes a message
    *
    * @param string $body the XML of the SOAP body
    * @param mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
    * @param array $namespaces optional the namespaces used in generating the body and headers
    * @param string $style optional (rpc|document)
    * @param string $use optional (encoded|literal)
    * @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
    * @return string the message
    * @access public
    */
	public function serializeEnvelope($body, $headers = false, $namespaces = array(), $style = 'rpc', $use = 'encoded', $encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/')
	{
		$this->debug('In serializeEnvelope length=' . strlen($body) . ' body (max 1000 characters)=' . substr($body, 0, 1000) . (' style=' . $style . ' use=' . $use . ' encodingStyle=' . $encodingStyle));
		$this->debug('headers:');
		$this->appendDebug($this->varDump($headers));
		$this->debug('namespaces:');
		$this->appendDebug($this->varDump($namespaces));
		$ns_string = '';

		foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
			$ns_string .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if ($encodingStyle) {
			$ns_string = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"' . $ns_string;
		}

		if ($headers) {
			if (is_array($headers)) {
				$xml = '';

				foreach ($headers as $k => $v) {
					if (is_object($v) && get_class($v) == 'soapval') {
						$xml .= $this->serialize_val($v, false, false, false, false, false, $use);
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$headers = $xml;
				$this->debug('In serializeEnvelope, serialized array of headers to ' . $headers);
			}

			$headers = '<SOAP-ENV:Header>' . $headers . '</SOAP-ENV:Header>';
		}

		return '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?' . '>' . '<SOAP-ENV:Envelope' . $ns_string . '>' . $headers . '<SOAP-ENV:Body>' . $body . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
	}

	/**
	 * formats a string to be inserted into an HTML stream
	 *
	 * @param string $str The string to format
	 * @return string The formatted string
	 * @access public
	 * @deprecated
	 */
	public function formatDump($str)
	{
		$str = htmlspecialchars($str);
		return nl2br($str);
	}

	/**
	* contracts (changes namespace to prefix) a qualified name
	*
	* @param    string $qname qname
	* @return	string contracted qname
	* @access   private
	*/
	public function contractQname($qname)
	{
		if (strrpos($qname, ':')) {
			$name = substr($qname, strrpos($qname, ':') + 1);
			$ns = substr($qname, 0, strrpos($qname, ':'));
			$p = $this->getPrefixFromNamespace($ns);

			if ($p) {
				return $p . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
	* expands (changes prefix to namespace) a qualified name
	*
	* @param    string $qname qname
	* @return	string expanded qname
	* @access   private
	*/
	public function expandQname($qname)
	{
		if (strpos($qname, ':') && !preg_match('/^http:\\/\\//', $qname)) {
			$name = substr(strstr($qname, ':'), 1);
			$prefix = substr($qname, 0, strpos($qname, ':'));

			if (isset($this->namespaces[$prefix])) {
				return $this->namespaces[$prefix] . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
    * returns the local part of a prefixed string
    * returns the original string, if not prefixed
    *
    * @param string $str The prefixed string
    * @return string The local part
    * @access public
    */
	public function getLocalPart($str)
	{
		if ($sstr = strrchr($str, ':')) {
			return substr($sstr, 1);
		}

		return $str;
	}

	/**
    * returns the prefix part of a prefixed string
    * returns false, if not prefixed
    *
    * @param string $str The prefixed string
    * @return mixed The prefix or false if there is no prefix
    * @access public
    */
	public function getPrefix($str)
	{
		if ($pos = strrpos($str, ':')) {
			return substr($str, 0, $pos);
		}

		return false;
	}

	/**
    * pass it a prefix, it returns a namespace
    *
    * @param string $prefix The prefix
    * @return mixed The namespace, false if no namespace has the specified prefix
    * @access public
    */
	public function getNamespaceFromPrefix($prefix)
	{
		if (isset($this->namespaces[$prefix])) {
			return $this->namespaces[$prefix];
		}

		return false;
	}

	/**
    * returns the prefix for a given namespace (or prefix)
    * or false if no prefixes registered for the given namespace
    *
    * @param string $ns The namespace
    * @return mixed The prefix, false if the namespace has no prefixes
    * @access public
    */
	public function getPrefixFromNamespace($ns)
	{
		foreach ($this->namespaces as $p => $n) {
			if ($ns == $n || $ns == $p) {
				$this->usedNamespaces[$p] = $n;
				return $p;
			}
		}

		return false;
	}

	/**
    * returns the time in ODBC canonical form with microseconds
    *
    * @return string The time in ODBC canonical form with microseconds
    * @access public
    */
	public function getmicrotime()
	{
		if (function_exists('gettimeofday')) {
			$tod = gettimeofday();
			$sec = $tod['sec'];
			$usec = $tod['usec'];
		}
		else {
			$sec = time();
			$usec = 0;
		}

		return strftime('%Y-%m-%d %H:%M:%S', $sec) . '.' . sprintf('%06d', $usec);
	}

	/**
	 * Returns a string with the output of var_dump
	 *
	 * @param mixed $data The variable to var_dump
	 * @return string The output of var_dump
	 * @access public
	 */
	public function varDump($data)
	{
		ob_start();
		var_dump($data);
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	/**
	* represents the object as a string
	*
	* @return	string
	* @access   public
	*/
	public function __toString()
	{
		return $this->varDump($this);
	}
}

class wsdl extends nusoap_base
{
	public $wsdl;
	public $schemas = array();
	public $currentSchema;
	public $message = array();
	public $complexTypes = array();
	public $messages = array();
	public $currentMessage;
	public $currentOperation;
	public $portTypes = array();
	public $currentPortType;
	public $bindings = array();
	public $currentBinding;
	public $ports = array();
	public $currentPort;
	public $opData = array();
	public $status = '';
	public $documentation = false;
	public $endpoint = '';
	public $import = array();
	public $parser;
	public $position = 0;
	public $depth = 0;
	public $depth_array = array();
	public $proxyhost = '';
	public $proxyport = '';
	public $proxyusername = '';
	public $proxypassword = '';
	public $timeout = 0;
	public $response_timeout = 30;
	public $curl_options = array();
	public $use_curl = false;
	public $username = '';
	public $password = '';
	public $authtype = '';
	public $certRequest = array();
	/**
	 * Identification for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $title = 'NuSOAP';
	/**
	 * Version for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $version = '0.9.5';
	/**
	 * CVS revision for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $revision = '$Revision: 1.123 $';
	/**
     * Current error string (manipulated by getError/setError)
	 *
	 * @var string
	 * @access private
	 */
	public $error_str = '';
	/**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
	 *
	 * @var string
	 * @access private
	 */
	public $debug_str = '';
	/**
	 * toggles automatic encoding of special characters as entities
	 * (should always be true, I think)
	 *
	 * @var boolean
	 * @access private
	 */
	public $charencoding = true;
	/**
	 * the debug level for this instance
	 *
	 * @var	integer
	 * @access private
	 */
	public $debugLevel;
	/**
	* set schema version
	*
	* @var      string
	* @access   public
	*/
	public $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';
	/**
	* charset encoding for outgoing messages
	*
	* @var      string
	* @access   public
	*/
	public $soap_defencoding = 'ISO-8859-1';
	/**
	* namespaces in an array of prefix => uri
	*
	* this is "seeded" by a set of constants, but it may be altered by code
	*
	* @var      array
	* @access   public
	*/
	public $namespaces = array('SOAP-ENV' => 'http://schemas.xmlsoap.org/soap/envelope/', 'xsd' => 'http://www.w3.org/2001/XMLSchema', 'xsi' => 'http://www.w3.org/2001/XMLSchema-instance', 'SOAP-ENC' => 'http://schemas.xmlsoap.org/soap/encoding/');
	/**
	* namespaces used in the current context, e.g. during serialization
	*
	* @var      array
	* @access   private
	*/
	public $usedNamespaces = array();
	/**
	* XML Schema types in an array of uri => (array of xml type => php type)
	* is this legacy yet?
	* no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
	* @var      array
	* @access   public
	*/
	public $typemap = array(
		'http://www.w3.org/2001/XMLSchema'          => array('string' => 'string', 'boolean' => 'boolean', 'float' => 'double', 'double' => 'double', 'decimal' => 'double', 'duration' => '', 'dateTime' => 'string', 'time' => 'string', 'date' => 'string', 'gYearMonth' => '', 'gYear' => '', 'gMonthDay' => '', 'gDay' => '', 'gMonth' => '', 'hexBinary' => 'string', 'base64Binary' => 'string', 'anyType' => 'string', 'anySimpleType' => 'string', 'normalizedString' => 'string', 'token' => 'string', 'language' => '', 'NMTOKEN' => '', 'NMTOKENS' => '', 'Name' => '', 'NCName' => '', 'ID' => '', 'IDREF' => '', 'IDREFS' => '', 'ENTITY' => '', 'ENTITIES' => '', 'integer' => 'integer', 'nonPositiveInteger' => 'integer', 'negativeInteger' => 'integer', 'long' => 'integer', 'int' => 'integer', 'short' => 'integer', 'byte' => 'integer', 'nonNegativeInteger' => 'integer', 'unsignedLong' => '', 'unsignedInt' => '', 'unsignedShort' => '', 'unsignedByte' => '', 'positiveInteger' => ''),
		'http://www.w3.org/2000/10/XMLSchema'       => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://www.w3.org/1999/XMLSchema'          => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://soapinterop.org/xsd'                => array('SOAPStruct' => 'struct'),
		'http://schemas.xmlsoap.org/soap/encoding/' => array('base64' => 'string', 'array' => 'array', 'Array' => 'array'),
		'http://xml.apache.org/xml-soap'            => array('Map')
		);
	/**
	* XML entities to convert
	*
	* @var      array
	* @access   public
	* @deprecated
	* @see	expandEntities
	*/
	public $xmlEntities = array('quot' => '"', 'amp' => '&', 'lt' => '<', 'gt' => '>', 'apos' => '\'');

	/**
     * constructor
     * 
     * @param string $wsdl WSDL document URL
	 * @param string $proxyhost
	 * @param string $proxyport
	 * @param string $proxyusername
	 * @param string $proxypassword
	 * @param integer $timeout set the connection timeout
	 * @param integer $response_timeout set the response timeout
	 * @param array $curl_options user-specified cURL options
	 * @param boolean $use_curl try to use cURL
     * @access public 
     */
	public function wsdl($wsdl = '', $proxyhost = false, $proxyport = false, $proxyusername = false, $proxypassword = false, $timeout = 0, $response_timeout = 30, $curl_options = NULL, $use_curl = false)
	{
		parent::nusoap_base();
		$this->debug('ctor wsdl=' . $wsdl . ' timeout=' . $timeout . ' response_timeout=' . $response_timeout);
		$this->proxyhost = $proxyhost;
		$this->proxyport = $proxyport;
		$this->proxyusername = $proxyusername;
		$this->proxypassword = $proxypassword;
		$this->timeout = $timeout;
		$this->response_timeout = $response_timeout;

		if (is_array($curl_options)) {
			$this->curl_options = $curl_options;
		}

		$this->use_curl = $use_curl;
		$this->fetchWSDL($wsdl);
	}

	/**
	 * fetches the WSDL document and parses it
	 *
	 * @access public
	 */
	public function fetchWSDL($wsdl)
	{
		$this->debug('parse and process WSDL path=' . $wsdl);
		$this->wsdl = $wsdl;

		if ($this->wsdl != '') {
			$this->parseWSDL($this->wsdl);
		}

		$imported_urls = array();
		$imported = 1;

		while (0 < $imported) {
			$imported = 0;

			foreach ($this->schemas as $ns => $list) {
				foreach ($list as $xs) {
					$wsdlparts = parse_url($this->wsdl);

					foreach ($xs->imports as $ns2 => $list2) {
						$ii = 0;

						while ($ii < count($list2)) {
							if (!$list2[$ii]['loaded']) {
								$this->schemas[$ns]->imports[$ns2][$ii]['loaded'] = true;
								$url = $list2[$ii]['location'];

								if ($url != '') {
									$urlparts = parse_url($url);

									if (!isset($urlparts['host'])) {
										$url = $wsdlparts['scheme'] . '://' . $wsdlparts['host'] . (isset($wsdlparts['port']) ? ':' . $wsdlparts['port'] : '') . substr($wsdlparts['path'], 0, strrpos($wsdlparts['path'], '/') + 1) . $urlparts['path'];
									}

									if (!in_array($url, $imported_urls)) {
										$this->parseWSDL($url);
										++$imported;
										$imported_urls[] = $url;
									}
								}
								else {
									$this->debug('Unexpected scenario: empty URL for unloaded import');
								}
							}

							++$ii;
						}
					}
				}
			}

			$wsdlparts = parse_url($this->wsdl);

			foreach ($this->import as $ns => $list) {
				$ii = 0;

				while ($ii < count($list)) {
					if (!$list[$ii]['loaded']) {
						$this->import[$ns][$ii]['loaded'] = true;
						$url = $list[$ii]['location'];

						if ($url != '') {
							$urlparts = parse_url($url);

							if (!isset($urlparts['host'])) {
								$url = $wsdlparts['scheme'] . '://' . $wsdlparts['host'] . (isset($wsdlparts['port']) ? ':' . $wsdlparts['port'] : '') . substr($wsdlparts['path'], 0, strrpos($wsdlparts['path'], '/') + 1) . $urlparts['path'];
							}

							if (!in_array($url, $imported_urls)) {
								$this->parseWSDL($url);
								++$imported;
								$imported_urls[] = $url;
							}
						}
						else {
							$this->debug('Unexpected scenario: empty URL for unloaded import');
						}
					}

					++$ii;
				}
			}
		}

		foreach ($this->bindings as $binding => $bindingData) {
			if (isset($bindingData['operations']) && is_array($bindingData['operations'])) {
				foreach ($bindingData['operations'] as $operation => $data) {
					$this->debug('post-parse data gathering for ' . $operation);
					$this->bindings[$binding]['operations'][$operation]['input'] = isset($this->bindings[$binding]['operations'][$operation]['input']) ? array_merge($this->bindings[$binding]['operations'][$operation]['input'], $this->portTypes[$bindingData['portType']][$operation]['input']) : $this->portTypes[$bindingData['portType']][$operation]['input'];
					$this->bindings[$binding]['operations'][$operation]['output'] = isset($this->bindings[$binding]['operations'][$operation]['output']) ? array_merge($this->bindings[$binding]['operations'][$operation]['output'], $this->portTypes[$bindingData['portType']][$operation]['output']) : $this->portTypes[$bindingData['portType']][$operation]['output'];

					if (isset($this->messages[$this->bindings[$binding]['operations'][$operation]['input']['message']])) {
						$this->bindings[$binding]['operations'][$operation]['input']['parts'] = $this->messages[$this->bindings[$binding]['operations'][$operation]['input']['message']];
					}

					if (isset($this->messages[$this->bindings[$binding]['operations'][$operation]['output']['message']])) {
						$this->bindings[$binding]['operations'][$operation]['output']['parts'] = $this->messages[$this->bindings[$binding]['operations'][$operation]['output']['message']];
					}

					if (isset($bindingData['style']) && !isset($this->bindings[$binding]['operations'][$operation]['style'])) {
						$this->bindings[$binding]['operations'][$operation]['style'] = $bindingData['style'];
					}

					$this->bindings[$binding]['operations'][$operation]['transport'] = isset($bindingData['transport']) ? $bindingData['transport'] : '';
					$this->bindings[$binding]['operations'][$operation]['documentation'] = isset($this->portTypes[$bindingData['portType']][$operation]['documentation']) ? $this->portTypes[$bindingData['portType']][$operation]['documentation'] : '';
					$this->bindings[$binding]['operations'][$operation]['endpoint'] = isset($bindingData['endpoint']) ? $bindingData['endpoint'] : '';
				}
			}
		}
	}

	/**
     * parses the wsdl document
     * 
     * @param string $wsdl path or URL
     * @access private 
     */
	public function parseWSDL($wsdl = '')
	{
		$this->debug('parse WSDL at path=' . $wsdl);

		if ($wsdl == '') {
			$this->debug('no wsdl passed to parseWSDL()!!');
			$this->setError('no wsdl passed to parseWSDL()!!');
			return false;
		}

		$wsdl_props = parse_url($wsdl);
		if (isset($wsdl_props['scheme']) && ($wsdl_props['scheme'] == 'http' || $wsdl_props['scheme'] == 'https')) {
			$this->debug('getting WSDL http(s) URL ' . $wsdl);
			$tr = new soap_transport_http($wsdl, $this->curl_options, $this->use_curl);
			$tr->request_method = 'GET';
			$tr->useSOAPAction = false;
			if ($this->proxyhost && $this->proxyport) {
				$tr->setProxy($this->proxyhost, $this->proxyport, $this->proxyusername, $this->proxypassword);
			}

			if ($this->authtype != '') {
				$tr->setCredentials($this->username, $this->password, $this->authtype, array(), $this->certRequest);
			}

			$tr->setEncoding('gzip, deflate');
			$wsdl_string = $tr->send('', $this->timeout, $this->response_timeout);
			$this->appendDebug($tr->getDebug());

			if ($err = $tr->getError()) {
				$errstr = 'Getting ' . $wsdl . ' - HTTP ERROR: ' . $err;
				$this->debug($errstr);
				$this->setError($errstr);
				unset($tr);
				return false;
			}

			unset($tr);
			$this->debug('got WSDL URL');
		}
		else {
			if (isset($wsdl_props['scheme']) && $wsdl_props['scheme'] == 'file' && isset($wsdl_props['path'])) {
				$path = isset($wsdl_props['host']) ? $wsdl_props['host'] . ':' . $wsdl_props['path'] : $wsdl_props['path'];
			}
			else {
				$path = $wsdl;
			}

			$this->debug('getting WSDL file ' . $path);

			if ($fp = @fopen($path, 'r')) {
				$wsdl_string = '';

				while ($data = fread($fp, 32768)) {
					$wsdl_string .= $data;
				}

				fclose($fp);
			}
			else {
				$errstr = 'Bad path to WSDL file ' . $path;
				$this->debug($errstr);
				$this->setError($errstr);
				return false;
			}
		}

		$this->debug('Parse WSDL');
		$this->parser = xml_parser_create();
		xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);
		xml_set_object($this->parser, $this);
		xml_set_element_handler($this->parser, 'start_element', 'end_element');
		xml_set_character_data_handler($this->parser, 'character_data');

		if (!xml_parse($this->parser, $wsdl_string, true)) {
			$errstr = sprintf('XML error parsing WSDL from %s on line %d: %s', $wsdl, xml_get_current_line_number($this->parser), xml_error_string(xml_get_error_code($this->parser)));
			$this->debug($errstr);
			$this->debug("XML payload:\n" . $wsdl_string);
			$this->setError($errstr);
			return false;
		}

		xml_parser_free($this->parser);
		$this->debug('Parsing WSDL done');

		if ($this->getError()) {
			return false;
		}

		return true;
	}

	/**
     * start-element handler
     * 
     * @param string $parser XML parser object
     * @param string $name element name
     * @param string $attrs associative array of attributes
     * @access private 
     */
	public function start_element($parser, $name, $attrs)
	{
		if ($this->status == 'schema') {
			$this->currentSchema->schemaStartElement($parser, $name, $attrs);
			$this->appendDebug($this->currentSchema->getDebug());
			$this->currentSchema->clearDebug();
			return NULL;
		}

		if (preg_match('/schema$/', $name)) {
			$this->debug('Parsing WSDL schema');
			$this->status = 'schema';
			$this->currentSchema = new nusoap_xmlschema('', '', $this->namespaces);
			$this->currentSchema->schemaStartElement($parser, $name, $attrs);
			$this->appendDebug($this->currentSchema->getDebug());
			$this->currentSchema->clearDebug();
			return NULL;
		}

		$pos = $this->position++;
		$depth = $this->depth++;
		$this->depth_array[$depth] = $pos;
		$this->message[$pos] = array('cdata' => '');

		if (0 < count($attrs)) {
			foreach ($attrs as $k => $v) {
				if (preg_match('/^xmlns/', $k)) {
					if ($ns_prefix = substr(strrchr($k, ':'), 1)) {
						$this->namespaces[$ns_prefix] = $v;
					}
					else {
						$this->namespaces['ns' . (count($this->namespaces) + 1)] = $v;
					}

					if ($v == 'http://www.w3.org/2001/XMLSchema' || $v == 'http://www.w3.org/1999/XMLSchema' || $v == 'http://www.w3.org/2000/10/XMLSchema') {
						$this->XMLSchemaVersion = $v;
						$this->namespaces['xsi'] = $v . '-instance';
					}
				}
			}

			foreach ($attrs as $k => $v) {
				$k = strpos($k, ':') ? $this->expandQname($k) : $k;
				if ($k != 'location' && $k != 'soapAction' && $k != 'namespace') {
					$v = strpos($v, ':') ? $this->expandQname($v) : $v;
				}

				$eAttrs[$k] = $v;
			}

			$attrs = $eAttrs;
		}
		else {
			$attrs = array();
		}

		if (preg_match('/:/', $name)) {
			$prefix = substr($name, 0, strpos($name, ':'));
			$namespace = isset($this->namespaces[$prefix]) ? $this->namespaces[$prefix] : '';
			$name = substr(strstr($name, ':'), 1);
		}

		switch ($this->status) {
		case 'message':
			if ($name == 'part') {
				if (isset($attrs['type'])) {
					$this->debug('msg ' . $this->currentMessage . (': found part (with type) ' . $attrs['name'] . ': ') . implode(',', $attrs));
					$this->messages[$this->currentMessage][$attrs['name']] = $attrs['type'];
				}

				if (isset($attrs['element'])) {
					$this->debug('msg ' . $this->currentMessage . (': found part (with element) ' . $attrs['name'] . ': ') . implode(',', $attrs));
					$this->messages[$this->currentMessage][$attrs['name']] = $attrs['element'] . '^';
				}
			}

			break;

		case 'portType':
			switch ($name) {
			case 'operation':
				$this->currentPortOperation = $attrs['name'];
				$this->debug('portType ' . $this->currentPortType . ' operation: ' . $this->currentPortOperation);

				if (isset($attrs['parameterOrder'])) {
					$this->portTypes[$this->currentPortType][$attrs['name']]['parameterOrder'] = $attrs['parameterOrder'];
				}

				break;

			case 'documentation':
				$this->documentation = true;
				break;

			default:
				$m = isset($attrs['message']) ? $this->getLocalPart($attrs['message']) : '';
				$this->portTypes[$this->currentPortType][$this->currentPortOperation][$name]['message'] = $m;
				break;
			}

			break;

		case 'binding':
			switch ($name) {
			case 'binding':
				if (isset($attrs['style'])) {
					$this->bindings[$this->currentBinding]['prefix'] = $prefix;
				}

				$this->bindings[$this->currentBinding] = array_merge($this->bindings[$this->currentBinding], $attrs);
				break;

			case 'header':
				$this->bindings[$this->currentBinding]['operations'][$this->currentOperation][$this->opStatus]['headers'][] = $attrs;
				break;

			case 'operation':
				if (isset($attrs['soapAction'])) {
					$this->bindings[$this->currentBinding]['operations'][$this->currentOperation]['soapAction'] = $attrs['soapAction'];
				}

				if (isset($attrs['style'])) {
					$this->bindings[$this->currentBinding]['operations'][$this->currentOperation]['style'] = $attrs['style'];
				}

				if (isset($attrs['name'])) {
					$this->currentOperation = $attrs['name'];
					$this->debug('current binding operation: ' . $this->currentOperation);
					$this->bindings[$this->currentBinding]['operations'][$this->currentOperation]['name'] = $attrs['name'];
					$this->bindings[$this->currentBinding]['operations'][$this->currentOperation]['binding'] = $this->currentBinding;
					$this->bindings[$this->currentBinding]['operations'][$this->currentOperation]['endpoint'] = isset($this->bindings[$this->currentBinding]['endpoint']) ? $this->bindings[$this->currentBinding]['endpoint'] : '';
				}

				break;

			case 'input':
				$this->opStatus = 'input';
				break;

			case 'output':
				$this->opStatus = 'output';
				break;

			case 'body':
				if (isset($this->bindings[$this->currentBinding]['operations'][$this->currentOperation][$this->opStatus])) {
					$this->bindings[$this->currentBinding]['operations'][$this->currentOperation][$this->opStatus] = array_merge($this->bindings[$this->currentBinding]['operations'][$this->currentOperation][$this->opStatus], $attrs);
				}
				else {
					$this->bindings[$this->currentBinding]['operations'][$this->currentOperation][$this->opStatus] = $attrs;
				}

				break;
			}

			break;

		case 'service':
			switch ($name) {
			case 'port':
				$this->currentPort = $attrs['name'];
				$this->debug('current port: ' . $this->currentPort);
				$this->ports[$this->currentPort]['binding'] = $this->getLocalPart($attrs['binding']);
				break;

			case 'address':
				$this->ports[$this->currentPort]['location'] = $attrs['location'];
				$this->ports[$this->currentPort]['bindingType'] = $namespace;
				$this->bindings[$this->ports[$this->currentPort]['binding']]['bindingType'] = $namespace;
				$this->bindings[$this->ports[$this->currentPort]['binding']]['endpoint'] = $attrs['location'];
				break;
			}

			break;
		}

		switch ($name) {
		case 'import':
			if (isset($attrs['location'])) {
				$this->import[$attrs['namespace']][] = array('location' => $attrs['location'], 'loaded' => false);
				$this->debug('parsing import ' . $attrs['namespace'] . ' - ' . $attrs['location'] . ' (' . count($this->import[$attrs['namespace']]) . ')');
			}
			else {
				$this->import[$attrs['namespace']][] = array('location' => '', 'loaded' => true);

				if (!$this->getPrefixFromNamespace($attrs['namespace'])) {
					$this->namespaces['ns' . (count($this->namespaces) + 1)] = $attrs['namespace'];
				}

				$this->debug('parsing import ' . $attrs['namespace'] . ' - [no location] (' . count($this->import[$attrs['namespace']]) . ')');
			}

			break;

		case 'message':
			$this->status = 'message';
			$this->messages[$attrs['name']] = array();
			$this->currentMessage = $attrs['name'];
			break;

		case 'portType':
			$this->status = 'portType';
			$this->portTypes[$attrs['name']] = array();
			$this->currentPortType = $attrs['name'];
			break;

		case 'binding':
			if (isset($attrs['name'])) {
				if (strpos($attrs['name'], ':')) {
					$this->currentBinding = $this->getLocalPart($attrs['name']);
				}
				else {
					$this->currentBinding = $attrs['name'];
				}

				$this->status = 'binding';
				$this->bindings[$this->currentBinding]['portType'] = $this->getLocalPart($attrs['type']);
				$this->debug('current binding: ' . $this->currentBinding . ' of portType: ' . $attrs['type']);
			}

			break;

		case 'service':
			$this->serviceName = $attrs['name'];
			$this->status = 'service';
			$this->debug('current service: ' . $this->serviceName);
			break;

		case 'definitions':
			foreach ($attrs as $name => $value) {
				$this->wsdl_info[$name] = $value;
			}

			break;
		}
	}

	/**
	* end-element handler
	* 
	* @param string $parser XML parser object
	* @param string $name element name
	* @access private 
	*/
	public function end_element($parser, $name)
	{
		if (preg_match('/schema$/', $name)) {
			$this->status = '';
			$this->appendDebug($this->currentSchema->getDebug());
			$this->currentSchema->clearDebug();
			$this->schemas[$this->currentSchema->schemaTargetNamespace][] = $this->currentSchema;
			$this->debug('Parsing WSDL schema done');
		}

		if ($this->status == 'schema') {
			$this->currentSchema->schemaEndElement($parser, $name);
		}
		else {
			$this->depth--;
		}

		if ($this->documentation) {
			$this->documentation = false;
		}
	}

	/**
	 * element content handler
	 * 
	 * @param string $parser XML parser object
	 * @param string $data element content
	 * @access private 
	 */
	public function character_data($parser, $data)
	{
		$pos = isset($this->depth_array[$this->depth]) ? $this->depth_array[$this->depth] : 0;

		if (isset($this->message[$pos]['cdata'])) {
			$this->message[$pos]['cdata'] .= $data;
		}

		if ($this->documentation) {
			$this->documentation .= $data;
		}
	}

	/**
	* if authenticating, set user credentials here
	*
	* @param    string $username
	* @param    string $password
	* @param	string $authtype (basic|digest|certificate|ntlm)
	* @param	array $certRequest (keys must be cainfofile (optional), sslcertfile, sslkeyfile, passphrase, certpassword (optional), verifypeer (optional), verifyhost (optional): see corresponding options in cURL docs)
	* @access   public
	*/
	public function setCredentials($username, $password, $authtype = 'basic', $certRequest = array())
	{
		$this->debug('setCredentials username=' . $username . ' authtype=' . $authtype . ' certRequest=');
		$this->appendDebug($this->varDump($certRequest));
		$this->username = $username;
		$this->password = $password;
		$this->authtype = $authtype;
		$this->certRequest = $certRequest;
	}

	public function getBindingData($binding)
	{
		if (is_array($this->bindings[$binding])) {
			return $this->bindings[$binding];
		}
	}

	/**
	 * returns an assoc array of operation names => operation data
	 * 
	 * @param string $portName WSDL port name
	 * @param string $bindingType eg: soap, smtp, dime (only soap and soap12 are currently supported)
	 * @return array 
	 * @access public 
	 */
	public function getOperations($portName = '', $bindingType = 'soap')
	{
		$ops = array();

		if ($bindingType == 'soap') {
			$bindingType = 'http://schemas.xmlsoap.org/wsdl/soap/';
		}
		else if ($bindingType == 'soap12') {
			$bindingType = 'http://schemas.xmlsoap.org/wsdl/soap12/';
		}
		else {
			$this->debug('getOperations bindingType ' . $bindingType . ' may not be supported');
		}

		$this->debug('getOperations for port \'' . $portName . '\' bindingType ' . $bindingType);

		foreach ($this->ports as $port => $portData) {
			$this->debug('getOperations checking port ' . $port . ' bindingType ' . $portData['bindingType']);
			if ($portName == '' || $port == $portName) {
				if ($portData['bindingType'] == $bindingType) {
					$this->debug('getOperations found port ' . $port . ' bindingType ' . $bindingType);

					if (isset($this->bindings[$portData['binding']]['operations'])) {
						$ops = array_merge($ops, $this->bindings[$portData['binding']]['operations']);
					}
				}
			}
		}

		if (count($ops) == 0) {
			$this->debug('getOperations found no operations for port \'' . $portName . '\' bindingType ' . $bindingType);
		}

		return $ops;
	}

	/**
	 * returns an associative array of data necessary for calling an operation
	 * 
	 * @param string $operation name of operation
	 * @param string $bindingType type of binding eg: soap, soap12
	 * @return array 
	 * @access public 
	 */
	public function getOperationData($operation, $bindingType = 'soap')
	{
		if ($bindingType == 'soap') {
			$bindingType = 'http://schemas.xmlsoap.org/wsdl/soap/';
		}
		else {
			if ($bindingType == 'soap12') {
				$bindingType = 'http://schemas.xmlsoap.org/wsdl/soap12/';
			}
		}

		foreach ($this->ports as $port => $portData) {
			if ($portData['bindingType'] == $bindingType) {
				foreach (array_keys($this->bindings[$portData['binding']]['operations']) as $bOperation) {
					if ($operation == $bOperation) {
						$opData = $this->bindings[$portData['binding']]['operations'][$operation];
						return $opData;
					}
				}
			}
		}
	}

	/**
	 * returns an associative array of data necessary for calling an operation
	 * 
	 * @param string $soapAction soapAction for operation
	 * @param string $bindingType type of binding eg: soap, soap12
	 * @return array 
	 * @access public 
	 */
	public function getOperationDataForSoapAction($soapAction, $bindingType = 'soap')
	{
		if ($bindingType == 'soap') {
			$bindingType = 'http://schemas.xmlsoap.org/wsdl/soap/';
		}
		else {
			if ($bindingType == 'soap12') {
				$bindingType = 'http://schemas.xmlsoap.org/wsdl/soap12/';
			}
		}

		foreach ($this->ports as $port => $portData) {
			if ($portData['bindingType'] == $bindingType) {
				foreach ($this->bindings[$portData['binding']]['operations'] as $bOperation => $opData) {
					if ($opData['soapAction'] == $soapAction) {
						return $opData;
					}
				}
			}
		}
	}

	/**
    * returns an array of information about a given type
    * returns false if no type exists by the given name
    *
	*	 typeDef = array(
	*	 'elements' => array(), // refs to elements array
	*	'restrictionBase' => '',
	*	'phpType' => '',
	*	'order' => '(sequence|all)',
	*	'attrs' => array() // refs to attributes array
	*	)
    *
    * @param string $type the type
    * @param string $ns namespace (not prefix) of the type
    * @return mixed
    * @access public
    * @see nusoap_xmlschema
    */
	public function getTypeDef($type, $ns)
	{
		$this->debug('in getTypeDef: type=' . $type . ', ns=' . $ns);
		if (!$ns && isset($this->namespaces['tns'])) {
			$ns = $this->namespaces['tns'];
			$this->debug('in getTypeDef: type namespace forced to ' . $ns);
		}

		if (!isset($this->schemas[$ns])) {
			foreach ($this->schemas as $ns0 => $schema0) {
				if (strcasecmp($ns, $ns0) == 0) {
					$this->debug('in getTypeDef: replacing schema namespace ' . $ns . ' with ' . $ns0);
					$ns = $ns0;
					break;
				}
			}
		}

		if (isset($this->schemas[$ns])) {
			$this->debug('in getTypeDef: have schema for namespace ' . $ns);
			$i = 0;

			while ($i < count($this->schemas[$ns])) {
				$xs = &$this->schemas[$ns][$i];
				$t = $xs->getTypeDef($type);
				$this->appendDebug($xs->getDebug());
				$xs->clearDebug();

				if ($t) {
					$this->debug('in getTypeDef: found type ' . $type);

					if (!isset($t['phpType'])) {
						$uqType = substr($t['type'], strrpos($t['type'], ':') + 1);
						$ns = substr($t['type'], 0, strrpos($t['type'], ':'));
						$etype = $this->getTypeDef($uqType, $ns);

						if ($etype) {
							$this->debug('found type for [element] ' . $type . ':');
							$this->debug($this->varDump($etype));

							if (isset($etype['phpType'])) {
								$t['phpType'] = $etype['phpType'];
							}

							if (isset($etype['elements'])) {
								$t['elements'] = $etype['elements'];
							}

							if (isset($etype['attrs'])) {
								$t['attrs'] = $etype['attrs'];
							}
						}
						else {
							$this->debug('did not find type for [element] ' . $type);
						}
					}

					return $t;
				}

				++$i;
			}

			$this->debug('in getTypeDef: did not find type ' . $type);
		}
		else {
			$this->debug('in getTypeDef: do not have schema for namespace ' . $ns);
		}

		return false;
	}

	/**
    * prints html description of services
    *
    * @access private
    */
	public function webDescription()
	{
		global $HTTP_SERVER_VARS;

		if (isset($_SERVER)) {
			$PHP_SELF = $_SERVER['PHP_SELF'];
		}
		else if (isset($HTTP_SERVER_VARS)) {
			$PHP_SELF = $HTTP_SERVER_VARS['PHP_SELF'];
		}
		else {
			$this->setError('Neither _SERVER nor HTTP_SERVER_VARS is available');
		}

		$b = "\r\n\t\t<html><head><title>NuSOAP: " . $this->serviceName . "</title>\r\n\t\t<style type=\"text/css\">\r\n\t\t    body    { font-family: arial; color: #000000; background-color: #ffffff; margin: 0px 0px 0px 0px; }\r\n\t\t    p       { font-family: arial; color: #000000; margin-top: 0px; margin-bottom: 12px; }\r\n\t\t    pre { background-color: silver; padding: 5px; font-family: Courier New; font-size: x-small; color: #000000;}\r\n\t\t    ul      { margin-top: 10px; margin-left: 20px; }\r\n\t\t    li      { list-style-type: none; margin-top: 10px; color: #000000; }\r\n\t\t    .content{\r\n\t\t\tmargin-left: 0px; padding-bottom: 2em; }\r\n\t\t    .nav {\r\n\t\t\tpadding-top: 10px; padding-bottom: 10px; padding-left: 15px; font-size: .70em;\r\n\t\t\tmargin-top: 10px; margin-left: 0px; color: #000000;\r\n\t\t\tbackground-color: #ccccff; width: 20%; margin-left: 20px; margin-top: 20px; }\r\n\t\t    .title {\r\n\t\t\tfont-family: arial; font-size: 26px; color: #ffffff;\r\n\t\t\tbackground-color: #999999; width: 100%;\r\n\t\t\tmargin-left: 0px; margin-right: 0px;\r\n\t\t\tpadding-top: 10px; padding-bottom: 10px;}\r\n\t\t    .hidden {\r\n\t\t\tposition: absolute; visibility: hidden; z-index: 200; left: 250px; top: 100px;\r\n\t\t\tfont-family: arial; overflow: hidden; width: 600;\r\n\t\t\tpadding: 20px; font-size: 10px; background-color: #999999;\r\n\t\t\tlayer-background-color:#FFFFFF; }\r\n\t\t    a,a:active  { color: charcoal; font-weight: bold; }\r\n\t\t    a:visited   { color: #666666; font-weight: bold; }\r\n\t\t    a:hover     { color: cc3300; font-weight: bold; }\r\n\t\t</style>\r\n\t\t<script language=\"JavaScript\" type=\"text/javascript\">\r\n\t\t<!--\r\n\t\t// POP-UP CAPTIONS...\r\n\t\tfunction lib_bwcheck(){ //Browsercheck (needed)\r\n\t\t    this.ver=navigator.appVersion\r\n\t\t    this.agent=navigator.userAgent\r\n\t\t    this.dom=document.getElementById?1:0\r\n\t\t    this.opera5=this.agent.indexOf(\"Opera 5\")>-1\r\n\t\t    this.ie5=(this.ver.indexOf(\"MSIE 5\")>-1 && this.dom && !this.opera5)?1:0;\r\n\t\t    this.ie6=(this.ver.indexOf(\"MSIE 6\")>-1 && this.dom && !this.opera5)?1:0;\r\n\t\t    this.ie4=(document.all && !this.dom && !this.opera5)?1:0;\r\n\t\t    this.ie=this.ie4||this.ie5||this.ie6\r\n\t\t    this.mac=this.agent.indexOf(\"Mac\")>-1\r\n\t\t    this.ns6=(this.dom && parseInt(this.ver) >= 5) ?1:0;\r\n\t\t    this.ns4=(document.layers && !this.dom)?1:0;\r\n\t\t    this.bw=(this.ie6 || this.ie5 || this.ie4 || this.ns4 || this.ns6 || this.opera5)\r\n\t\t    return this\r\n\t\t}\r\n\t\tvar bw = new lib_bwcheck()\r\n\t\t//Makes crossbrowser object.\r\n\t\tfunction makeObj(obj){\r\n\t\t    this.evnt=bw.dom? document.getElementById(obj):bw.ie4?document.all[obj]:bw.ns4?document.layers[obj]:0;\r\n\t\t    if(!this.evnt) return false\r\n\t\t    this.css=bw.dom||bw.ie4?this.evnt.style:bw.ns4?this.evnt:0;\r\n\t\t    this.wref=bw.dom||bw.ie4?this.evnt:bw.ns4?this.css.document:0;\r\n\t\t    this.writeIt=b_writeIt;\r\n\t\t    return this\r\n\t\t}\r\n\t\t// A unit of measure that will be added when setting the position of a layer.\r\n\t\t//var px = bw.ns4||window.opera?\"\":\"px\";\r\n\t\tfunction b_writeIt(text){\r\n\t\t    if (bw.ns4){this.wref.write(text);this.wref.close()}\r\n\t\t    else this.wref.innerHTML = text\r\n\t\t}\r\n\t\t//Shows the messages\r\n\t\tvar oDesc;\r\n\t\tfunction popup(divid){\r\n\t\t    if(oDesc = new makeObj(divid)){\r\n\t\t\toDesc.css.visibility = \"visible\"\r\n\t\t    }\r\n\t\t}\r\n\t\tfunction popout(){ // Hides message\r\n\t\t    if(oDesc) oDesc.css.visibility = \"hidden\"\r\n\t\t}\r\n\t\t//-->\r\n\t\t</script>\r\n\t\t</head>\r\n\t\t<body>\r\n\t\t<div class=content>\r\n\t\t\t<br><br>\r\n\t\t\t<div class=title>" . $this->serviceName . "</div>\r\n\t\t\t<div class=nav>\r\n\t\t\t\t<p>View the <a href=\"" . $PHP_SELF . "?wsdl\">WSDL</a> for the service.\r\n\t\t\t\tClick on an operation name to view it&apos;s details.</p>\r\n\t\t\t\t<ul>";

		foreach ($this->getOperations() as $op => $data) {
			$b .= '<li><a href=\'#\' onclick="popout();popup(\'' . $op . '\')">' . $op . '</a></li>';
			$b .= '<div id=\'' . $op . "' class='hidden'>\r\n\t\t\t\t    <a href='#' onclick='popout()'><font color='#ffffff'>Close</font></a><br><br>";

			foreach ($data as $donnie => $marie) {
				if ($donnie == 'input' || $donnie == 'output') {
					$b .= '<font color=\'white\'>' . ucfirst($donnie) . ':</font><br>';

					foreach ($marie as $captain => $tenille) {
						if ($captain == 'parts') {
							$b .= '&nbsp;&nbsp;' . $captain . ':<br>';

							foreach ($tenille as $joanie => $chachi) {
								$b .= '&nbsp;&nbsp;&nbsp;&nbsp;' . $joanie . ': ' . $chachi . '<br>';
							}
						}
						else {
							$b .= '&nbsp;&nbsp;' . $captain . ': ' . $tenille . '<br>';
						}
					}
				}
				else {
					$b .= '<font color=\'white\'>' . ucfirst($donnie) . (':</font> ' . $marie . '<br>');
				}
			}

			$b .= '</div>';
		}

		$b .= "\r\n\t\t\t\t<ul>\r\n\t\t\t</div>\r\n\t\t</div></body></html>";
		return $b;
	}

	/**
	* serialize the parsed wsdl
	*
	* @param mixed $debug whether to put debug=1 in endpoint URL
	* @return string serialization of WSDL
	* @access public 
	*/
	public function serialize($debug = 0)
	{
		$xml = '<?xml version="1.0" encoding="ISO-8859-1"?>';
		$xml .= "\n<definitions";

		foreach ($this->namespaces as $k => $v) {
			$xml .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if (isset($this->namespaces['wsdl'])) {
			$xml .= ' xmlns="' . $this->namespaces['wsdl'] . '"';
		}

		if (isset($this->namespaces['tns'])) {
			$xml .= ' targetNamespace="' . $this->namespaces['tns'] . '"';
		}

		$xml .= '>';

		if (0 < sizeof($this->import)) {
			foreach ($this->import as $ns => $list) {
				foreach ($list as $ii) {
					if ($ii['location'] != '') {
						$xml .= '<import location="' . $ii['location'] . '" namespace="' . $ns . '" />';
					}
					else {
						$xml .= '<import namespace="' . $ns . '" />';
					}
				}
			}
		}

		if (1 <= count($this->schemas)) {
			$xml .= "\n<types>\n";

			foreach ($this->schemas as $ns => $list) {
				foreach ($list as $xs) {
					$xml .= $xs->serializeSchema();
				}
			}

			$xml .= '</types>';
		}

		if (1 <= count($this->messages)) {
			foreach ($this->messages as $msgName => $msgParts) {
				$xml .= "\n<message name=\"" . $msgName . '">';

				if (is_array($msgParts)) {
					foreach ($msgParts as $partName => $partType) {
						if (strpos($partType, ':')) {
							$typePrefix = $this->getPrefixFromNamespace($this->getPrefix($partType));
						}
						else if (isset($this->typemap[$this->namespaces['xsd']][$partType])) {
							$typePrefix = 'xsd';
						}
						else {
							foreach ($this->typemap as $ns => $types) {
								if (isset($types[$partType])) {
									$typePrefix = $this->getPrefixFromNamespace($ns);
								}
							}

							if (!isset($typePrefix)) {
								exit($partType . ' has no namespace!');
							}
						}

						$ns = $this->getNamespaceFromPrefix($typePrefix);
						$localPart = $this->getLocalPart($partType);
						$typeDef = $this->getTypeDef($localPart, $ns);

						if ($typeDef['typeClass'] == 'element') {
							$elementortype = 'element';

							if (substr($localPart, -1) == '^') {
								$localPart = substr($localPart, 0, -1);
							}
						}
						else {
							$elementortype = 'type';
						}

						$xml .= "\n" . '  <part name="' . $partName . '" ' . $elementortype . '="' . $typePrefix . ':' . $localPart . '" />';
					}
				}

				$xml .= '</message>';
			}
		}

		if (1 <= count($this->bindings)) {
			$binding_xml = '';
			$portType_xml = '';

			foreach ($this->bindings as $bindingName => $attrs) {
				$binding_xml .= "\n<binding name=\"" . $bindingName . '" type="tns:' . $attrs['portType'] . '">';
				$binding_xml .= "\n" . '  <soap:binding style="' . $attrs['style'] . '" transport="' . $attrs['transport'] . '"/>';
				$portType_xml .= "\n<portType name=\"" . $attrs['portType'] . '">';

				foreach ($attrs['operations'] as $opName => $opParts) {
					$binding_xml .= "\n" . '  <operation name="' . $opName . '">';
					$binding_xml .= "\n" . '    <soap:operation soapAction="' . $opParts['soapAction'] . '" style="' . $opParts['style'] . '"/>';
					if (isset($opParts['input']['encodingStyle']) && $opParts['input']['encodingStyle'] != '') {
						$enc_style = ' encodingStyle="' . $opParts['input']['encodingStyle'] . '"';
					}
					else {
						$enc_style = '';
					}

					$binding_xml .= "\n" . '    <input><soap:body use="' . $opParts['input']['use'] . '" namespace="' . $opParts['input']['namespace'] . '"' . $enc_style . '/></input>';
					if (isset($opParts['output']['encodingStyle']) && $opParts['output']['encodingStyle'] != '') {
						$enc_style = ' encodingStyle="' . $opParts['output']['encodingStyle'] . '"';
					}
					else {
						$enc_style = '';
					}

					$binding_xml .= "\n" . '    <output><soap:body use="' . $opParts['output']['use'] . '" namespace="' . $opParts['output']['namespace'] . '"' . $enc_style . '/></output>';
					$binding_xml .= "\n" . '  </operation>';
					$portType_xml .= "\n" . '  <operation name="' . $opParts['name'] . '"';

					if (isset($opParts['parameterOrder'])) {
						$portType_xml .= ' parameterOrder="' . $opParts['parameterOrder'] . '"';
					}

					$portType_xml .= '>';
					if (isset($opParts['documentation']) && $opParts['documentation'] != '') {
						$portType_xml .= "\n" . '    <documentation>' . htmlspecialchars($opParts['documentation']) . '</documentation>';
					}

					$portType_xml .= "\n" . '    <input message="tns:' . $opParts['input']['message'] . '"/>';
					$portType_xml .= "\n" . '    <output message="tns:' . $opParts['output']['message'] . '"/>';
					$portType_xml .= "\n" . '  </operation>';
				}

				$portType_xml .= "\n" . '</portType>';
				$binding_xml .= "\n" . '</binding>';
			}

			$xml .= $portType_xml . $binding_xml;
		}

		$xml .= "\n<service name=\"" . $this->serviceName . '">';

		if (1 <= count($this->ports)) {
			foreach ($this->ports as $pName => $attrs) {
				$xml .= "\n" . '  <port name="' . $pName . '" binding="tns:' . $attrs['binding'] . '">';
				$xml .= "\n" . '    <soap:address location="' . $attrs['location'] . ($debug ? '?debug=1' : '') . '"/>';
				$xml .= "\n" . '  </port>';
			}
		}

		$xml .= "\n" . '</service>';
		return $xml . "\n</definitions>";
	}

	/**
	 * determine whether a set of parameters are unwrapped
	 * when they are expect to be wrapped, Microsoft-style.
	 *
	 * @param string $type the type (element name) of the wrapper
	 * @param array $parameters the parameter values for the SOAP call
	 * @return boolean whether they parameters are unwrapped (and should be wrapped)
	 * @access private
	 */
	public function parametersMatchWrapped($type, &$parameters)
	{
		$this->debug('in parametersMatchWrapped type=' . $type . ', parameters=');
		$this->appendDebug($this->varDump($parameters));

		if (strpos($type, ':')) {
			$uqType = substr($type, strrpos($type, ':') + 1);
			$ns = substr($type, 0, strrpos($type, ':'));
			$this->debug('in parametersMatchWrapped: got a prefixed type: ' . $uqType . ', ' . $ns);

			if ($this->getNamespaceFromPrefix($ns)) {
				$ns = $this->getNamespaceFromPrefix($ns);
				$this->debug('in parametersMatchWrapped: expanded prefixed type: ' . $uqType . ', ' . $ns);
			}
		}
		else {
			$this->debug('in parametersMatchWrapped: No namespace for type ' . $type);
			$ns = '';
			$uqType = $type;
		}

		if (!($typeDef = $this->getTypeDef($uqType, $ns))) {
			$this->debug('in parametersMatchWrapped: ' . $type . ' (' . $uqType . ') is not a supported type.');
			return false;
		}

		$this->debug('in parametersMatchWrapped: found typeDef=');
		$this->appendDebug($this->varDump($typeDef));

		if (substr($uqType, -1) == '^') {
			$uqType = substr($uqType, 0, -1);
		}

		$phpType = $typeDef['phpType'];
		$arrayType = isset($typeDef['arrayType']) ? $typeDef['arrayType'] : '';
		$this->debug('in parametersMatchWrapped: uqType: ' . $uqType . ', ns: ' . $ns . ', phptype: ' . $phpType . ', arrayType: ' . $arrayType);

		if ($phpType != 'struct') {
			$this->debug('in parametersMatchWrapped: not a struct');
			return false;
		}

		if (isset($typeDef['elements']) && is_array($typeDef['elements'])) {
			$elements = 0;
			$matches = 0;

			foreach ($typeDef['elements'] as $name => $attrs) {
				if (isset($parameters[$name])) {
					$this->debug('in parametersMatchWrapped: have parameter named ' . $name);
					++$matches;
				}
				else {
					$this->debug('in parametersMatchWrapped: do not have parameter named ' . $name);
				}

				++$elements;
			}

			$this->debug('in parametersMatchWrapped: ' . $matches . ' parameter names match ' . $elements . ' wrapped parameter names');

			if ($matches == 0) {
				return false;
			}

			return true;
		}

		$this->debug('in parametersMatchWrapped: no elements type ' . $ns . ':' . $uqType);
		return count($parameters) == 0;
	}

	/**
	 * serialize PHP values according to a WSDL message definition
	 * contrary to the method name, this is not limited to RPC
	 *
	 * TODO
	 * - multi-ref serialization
	 * - validate PHP values against type definitions, return errors if invalid
	 * 
	 * @param string $operation operation name
	 * @param string $direction (input|output)
	 * @param mixed $parameters parameter value(s)
	 * @param string $bindingType (soap|soap12)
	 * @return mixed parameters serialized as XML or false on error (e.g. operation not found)
	 * @access public
	 */
	public function serializeRPCParameters($operation, $direction, $parameters, $bindingType = 'soap')
	{
		$this->debug('in serializeRPCParameters: operation=' . $operation . ', direction=' . $direction . ', XMLSchemaVersion=' . $this->XMLSchemaVersion . ', bindingType=' . $bindingType);
		$this->appendDebug('parameters=' . $this->varDump($parameters));
		if ($direction != 'input' && $direction != 'output') {
			$this->debug('The value of the \\$direction argument needs to be either "input" or "output"');
			$this->setError('The value of the \\$direction argument needs to be either "input" or "output"');
			return false;
		}

		if (!($opData = $this->getOperationData($operation, $bindingType))) {
			$this->debug('Unable to retrieve WSDL data for operation: ' . $operation . ' bindingType: ' . $bindingType);
			$this->setError('Unable to retrieve WSDL data for operation: ' . $operation . ' bindingType: ' . $bindingType);
			return false;
		}

		$this->debug('in serializeRPCParameters: opData:');
		$this->appendDebug($this->varDump($opData));
		$encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/';
		if ($direction == 'input' && isset($opData['output']['encodingStyle']) && $opData['output']['encodingStyle'] != $encodingStyle) {
			$encodingStyle = $opData['output']['encodingStyle'];
			$enc_style = $encodingStyle;
		}

		$xml = '';
		if (isset($opData[$direction]['parts']) && 0 < sizeof($opData[$direction]['parts'])) {
			$parts = &$opData[$direction]['parts'];
			$part_count = sizeof($parts);
			$style = $opData['style'];
			$use = $opData[$direction]['use'];
			$this->debug('have ' . $part_count . ' part(s) to serialize using ' . $style . '/' . $use);

			if (is_array($parameters)) {
				$parametersArrayType = $this->isArraySimpleOrStruct($parameters);
				$parameter_count = count($parameters);
				$this->debug('have ' . $parameter_count . ' parameter(s) provided as ' . $parametersArrayType . ' to serialize');
				if ($style == 'document' && $use == 'literal' && $part_count == 1 && isset($parts['parameters'])) {
					$this->debug('check whether the caller has wrapped the parameters');
					if ($direction == 'output' && $parametersArrayType == 'arraySimple' && $parameter_count == 1) {
						$this->debug('change simple array to associative with \'parameters\' element');
						$parameters['parameters'] = $parameters[0];
						unset($parameters[0]);
					}

					if (($parametersArrayType == 'arrayStruct' || $parameter_count == 0) && !isset($parameters['parameters'])) {
						$this->debug('check whether caller\'s parameters match the wrapped ones');

						if ($this->parametersMatchWrapped($parts['parameters'], $parameters)) {
							$this->debug('wrap the parameters for the caller');
							$parameters = array('parameters' => $parameters);
							$parameter_count = 1;
						}
					}
				}

				foreach ($parts as $name => $type) {
					$this->debug('serializing part ' . $name . ' of type ' . $type);
					if (isset($opData[$direction]['encodingStyle']) && $encodingStyle != $opData[$direction]['encodingStyle']) {
						$encodingStyle = $opData[$direction]['encodingStyle'];
						$enc_style = $encodingStyle;
					}
					else {
						$enc_style = false;
					}

					if ($parametersArrayType == 'arraySimple') {
						$p = array_shift($parameters);
						$this->debug('calling serializeType w/indexed param');
						$xml .= $this->serializeType($name, $type, $p, $use, $enc_style);
					}
					else if (isset($parameters[$name])) {
						$this->debug('calling serializeType w/named param');
						$xml .= $this->serializeType($name, $type, $parameters[$name], $use, $enc_style);
					}
					else {
						$this->debug('calling serializeType w/null param');
						$xml .= $this->serializeType($name, $type, NULL, $use, $enc_style);
					}
				}
			}
			else {
				$this->debug('no parameters passed.');
			}
		}

		$this->debug('serializeRPCParameters returning: ' . $xml);
		return $xml;
	}

	/**
	 * serialize a PHP value according to a WSDL message definition
	 * 
	 * TODO
	 * - multi-ref serialization
	 * - validate PHP values against type definitions, return errors if invalid
	 * 
	 * @param string $operation operation name
	 * @param string $direction (input|output)
	 * @param mixed $parameters parameter value(s)
	 * @return mixed parameters serialized as XML or false on error (e.g. operation not found)
	 * @access public
	 * @deprecated
	 */
	public function serializeParameters($operation, $direction, $parameters)
	{
		$this->debug('in serializeParameters: operation=' . $operation . ', direction=' . $direction . ', XMLSchemaVersion=' . $this->XMLSchemaVersion);
		$this->appendDebug('parameters=' . $this->varDump($parameters));
		if ($direction != 'input' && $direction != 'output') {
			$this->debug('The value of the \\$direction argument needs to be either "input" or "output"');
			$this->setError('The value of the \\$direction argument needs to be either "input" or "output"');
			return false;
		}

		if (!($opData = $this->getOperationData($operation))) {
			$this->debug('Unable to retrieve WSDL data for operation: ' . $operation);
			$this->setError('Unable to retrieve WSDL data for operation: ' . $operation);
			return false;
		}

		$this->debug('opData:');
		$this->appendDebug($this->varDump($opData));
		$encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/';
		if ($direction == 'input' && isset($opData['output']['encodingStyle']) && $opData['output']['encodingStyle'] != $encodingStyle) {
			$encodingStyle = $opData['output']['encodingStyle'];
			$enc_style = $encodingStyle;
		}

		$xml = '';
		if (isset($opData[$direction]['parts']) && 0 < sizeof($opData[$direction]['parts'])) {
			$use = $opData[$direction]['use'];
			$this->debug('use=' . $use);
			$this->debug('got ' . count($opData[$direction]['parts']) . ' part(s)');

			if (is_array($parameters)) {
				$parametersArrayType = $this->isArraySimpleOrStruct($parameters);
				$this->debug('have ' . $parametersArrayType . ' parameters');

				foreach ($opData[$direction]['parts'] as $name => $type) {
					$this->debug('serializing part "' . $name . '" of type "' . $type . '"');
					if (isset($opData[$direction]['encodingStyle']) && $encodingStyle != $opData[$direction]['encodingStyle']) {
						$encodingStyle = $opData[$direction]['encodingStyle'];
						$enc_style = $encodingStyle;
					}
					else {
						$enc_style = false;
					}

					if ($parametersArrayType == 'arraySimple') {
						$p = array_shift($parameters);
						$this->debug('calling serializeType w/indexed param');
						$xml .= $this->serializeType($name, $type, $p, $use, $enc_style);
					}
					else if (isset($parameters[$name])) {
						$this->debug('calling serializeType w/named param');
						$xml .= $this->serializeType($name, $type, $parameters[$name], $use, $enc_style);
					}
					else {
						$this->debug('calling serializeType w/null param');
						$xml .= $this->serializeType($name, $type, NULL, $use, $enc_style);
					}
				}
			}
			else {
				$this->debug('no parameters passed.');
			}
		}

		$this->debug('serializeParameters returning: ' . $xml);
		return $xml;
	}

	/**
	 * serializes a PHP value according a given type definition
	 * 
	 * @param string $name name of value (part or element)
	 * @param string $type XML schema type of value (type or element)
	 * @param mixed $value a native PHP value (parameter value)
	 * @param string $use use for part (encoded|literal)
	 * @param string $encodingStyle SOAP encoding style for the value (if different than the enclosing style)
	 * @param boolean $unqualified a kludge for what should be XML namespace form handling
	 * @return string value serialized as an XML string
	 * @access private
	 */
	public function serializeType($name, $type, $value, $use = 'encoded', $encodingStyle = false, $unqualified = false)
	{
		$this->debug('in serializeType: name=' . $name . ', type=' . $type . ', use=' . $use . ', encodingStyle=' . $encodingStyle . ', unqualified=' . ($unqualified ? 'unqualified' : 'qualified'));
		$this->appendDebug('value=' . $this->varDump($value));
		if ($use == 'encoded' && $encodingStyle) {
			$encodingStyle = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"';
		}

		if (is_object($value) && get_class($value) == 'soapval') {
			if ($value->type_ns) {
				$type = $value->type_ns . ':' . $value->type;
				$forceType = true;
				$this->debug('in serializeType: soapval overrides type to ' . $type);
			}
			else if ($value->type) {
				$type = $value->type;
				$forceType = true;
				$this->debug('in serializeType: soapval overrides type to ' . $type);
			}
			else {
				$forceType = false;
				$this->debug('in serializeType: soapval does not override type');
			}

			$attrs = $value->attributes;
			$value = $value->value;
			$this->debug('in serializeType: soapval overrides value to ' . $value);

			if ($attrs) {
				if (!is_array($value)) {
					$value['!'] = $value;
				}

				foreach ($attrs as $n => $v) {
					$value['!' . $n] = $v;
				}

				$this->debug('in serializeType: soapval provides attributes');
			}
		}
		else {
			$forceType = false;
		}

		$xml = '';

		if (strpos($type, ':')) {
			$uqType = substr($type, strrpos($type, ':') + 1);
			$ns = substr($type, 0, strrpos($type, ':'));
			$this->debug('in serializeType: got a prefixed type: ' . $uqType . ', ' . $ns);

			if ($this->getNamespaceFromPrefix($ns)) {
				$ns = $this->getNamespaceFromPrefix($ns);
				$this->debug('in serializeType: expanded prefixed type: ' . $uqType . ', ' . $ns);
			}

			if ($ns == $this->XMLSchemaVersion || $ns == 'http://schemas.xmlsoap.org/soap/encoding/') {
				$this->debug('in serializeType: type namespace indicates XML Schema or SOAP Encoding type');
				if ($unqualified && $use == 'literal') {
					$elementNS = ' xmlns=""';
				}
				else {
					$elementNS = '';
				}

				if (is_null($value)) {
					if ($use == 'literal') {
						$xml = '<' . $name . $elementNS . '/>';
					}
					else {
						$xml = '<' . $name . $elementNS . ' xsi:nil="true" xsi:type="' . $this->getPrefixFromNamespace($ns) . (':' . $uqType . '"/>');
					}

					$this->debug('in serializeType: returning: ' . $xml);
					return $xml;
				}

				if ($uqType == 'Array') {
					return $this->serialize_val($value, $name, false, false, false, false, $use);
				}

				if ($uqType == 'boolean') {
					if (is_string($value) && $value == 'false' || !$value) {
						$value = 'false';
					}
					else {
						$value = 'true';
					}
				}

				if ($uqType == 'string' && gettype($value) == 'string') {
					$value = $this->expandEntities($value);
				}

				if (($uqType == 'long' || $uqType == 'unsignedLong') && gettype($value) == 'double') {
					$value = sprintf('%.0lf', $value);
				}

				if (!$this->getTypeDef($uqType, $ns)) {
					if ($use == 'literal') {
						if ($forceType) {
							$xml = '<' . $name . $elementNS . ' xsi:type="' . $this->getPrefixFromNamespace($ns) . (':' . $uqType . '">' . $value . '</' . $name . '>');
						}
						else {
							$xml = '<' . $name . $elementNS . '>' . $value . '</' . $name . '>';
						}
					}
					else {
						$xml = '<' . $name . $elementNS . ' xsi:type="' . $this->getPrefixFromNamespace($ns) . (':' . $uqType . '"' . $encodingStyle . '>' . $value . '</' . $name . '>');
					}

					$this->debug('in serializeType: returning: ' . $xml);
					return $xml;
				}

				$this->debug('custom type extends XML Schema or SOAP Encoding namespace (yuck)');
			}
			else {
				if ($ns == 'http://xml.apache.org/xml-soap') {
					$this->debug('in serializeType: appears to be Apache SOAP type');

					if ($uqType == 'Map') {
						$tt_prefix = $this->getPrefixFromNamespace('http://xml.apache.org/xml-soap');

						if (!$tt_prefix) {
							$this->debug('in serializeType: Add namespace for Apache SOAP type');
							$tt_prefix = 'ns' . rand(1000, 9999);
							$this->namespaces[$tt_prefix] = 'http://xml.apache.org/xml-soap';
							$tt_prefix = $this->getPrefixFromNamespace('http://xml.apache.org/xml-soap');
						}

						$contents = '';

						foreach ($value as $k => $v) {
							$this->debug('serializing map element: key ' . $k . ', value ' . $v);
							$contents .= '<item>';
							$contents .= $this->serialize_val($k, 'key', false, false, false, false, $use);
							$contents .= $this->serialize_val($v, 'value', false, false, false, false, $use);
							$contents .= '</item>';
						}

						if ($use == 'literal') {
							if ($forceType) {
								$xml = '<' . $name . ' xsi:type="' . $tt_prefix . (':' . $uqType . '">' . $contents . '</' . $name . '>');
							}
							else {
								$xml = '<' . $name . '>' . $contents . '</' . $name . '>';
							}
						}
						else {
							$xml = '<' . $name . ' xsi:type="' . $tt_prefix . (':' . $uqType . '"' . $encodingStyle . '>' . $contents . '</' . $name . '>');
						}

						$this->debug('in serializeType: returning: ' . $xml);
						return $xml;
					}

					$this->debug('in serializeType: Apache SOAP type, but only support Map');
				}
			}
		}
		else {
			$this->debug('in serializeType: No namespace for type ' . $type);
			$ns = '';
			$uqType = $type;
		}

		if (!($typeDef = $this->getTypeDef($uqType, $ns))) {
			$this->setError($type . ' (' . $uqType . ') is not a supported type.');
			$this->debug('in serializeType: ' . $type . ' (' . $uqType . ') is not a supported type.');
			return false;
		}

		$this->debug('in serializeType: found typeDef');
		$this->appendDebug('typeDef=' . $this->varDump($typeDef));

		if (substr($uqType, -1) == '^') {
			$uqType = substr($uqType, 0, -1);
		}

		if (!isset($typeDef['phpType'])) {
			$this->setError($type . ' (' . $uqType . ') has no phpType.');
			$this->debug('in serializeType: ' . $type . ' (' . $uqType . ') has no phpType.');
			return false;
		}

		$phpType = $typeDef['phpType'];
		$this->debug('in serializeType: uqType: ' . $uqType . ', ns: ' . $ns . ', phptype: ' . $phpType . ', arrayType: ' . (isset($typeDef['arrayType']) ? $typeDef['arrayType'] : ''));

		if ($phpType == 'struct') {
			if (isset($typeDef['typeClass']) && $typeDef['typeClass'] == 'element') {
				$elementName = $uqType;
				if (isset($typeDef['form']) && $typeDef['form'] == 'qualified') {
					$elementNS = ' xmlns="' . $ns . '"';
				}
				else {
					$elementNS = ' xmlns=""';
				}
			}
			else {
				$elementName = $name;

				if ($unqualified) {
					$elementNS = ' xmlns=""';
				}
				else {
					$elementNS = '';
				}
			}

			if (is_null($value)) {
				if ($use == 'literal') {
					$xml = '<' . $elementName . $elementNS . '/>';
				}
				else {
					$xml = '<' . $elementName . $elementNS . ' xsi:nil="true" xsi:type="' . $this->getPrefixFromNamespace($ns) . (':' . $uqType . '"/>');
				}

				$this->debug('in serializeType: returning: ' . $xml);
				return $xml;
			}

			if (is_object($value)) {
				$value = get_object_vars($value);
			}

			if (is_array($value)) {
				$elementAttrs = $this->serializeComplexTypeAttributes($typeDef, $value, $ns, $uqType);

				if ($use == 'literal') {
					if ($forceType) {
						$xml = '<' . $elementName . $elementNS . $elementAttrs . ' xsi:type="' . $this->getPrefixFromNamespace($ns) . (':' . $uqType . '">');
					}
					else {
						$xml = '<' . $elementName . $elementNS . $elementAttrs . '>';
					}
				}
				else {
					$xml = '<' . $elementName . $elementNS . $elementAttrs . ' xsi:type="' . $this->getPrefixFromNamespace($ns) . (':' . $uqType . '"' . $encodingStyle . '>');
				}

				if (isset($typeDef['simpleContent']) && $typeDef['simpleContent'] == 'true') {
					if (isset($value['!'])) {
						$xml .= $value['!'];
						$this->debug('in serializeType: serialized simpleContent for type ' . $type);
					}
					else {
						$this->debug('in serializeType: no simpleContent to serialize for type ' . $type);
					}
				}
				else {
					$xml .= $this->serializeComplexTypeElements($typeDef, $value, $ns, $uqType, $use, $encodingStyle);
				}

				$xml .= '</' . $elementName . '>';
			}
			else {
				$this->debug('in serializeType: phpType is struct, but value is not an array');
				$this->setError('phpType is struct, but value is not an array: see debug output for details');
				$xml = '';
			}
		}
		else if ($phpType == 'array') {
			if (isset($typeDef['form']) && $typeDef['form'] == 'qualified') {
				$elementNS = ' xmlns="' . $ns . '"';
			}
			else if ($unqualified) {
				$elementNS = ' xmlns=""';
			}
			else {
				$elementNS = '';
			}

			if (is_null($value)) {
				if ($use == 'literal') {
					$xml = '<' . $name . $elementNS . '/>';
				}
				else {
					$xml = '<' . $name . $elementNS . ' xsi:nil="true" xsi:type="' . $this->getPrefixFromNamespace('http://schemas.xmlsoap.org/soap/encoding/') . ':Array" ' . $this->getPrefixFromNamespace('http://schemas.xmlsoap.org/soap/encoding/') . ':arrayType="' . $this->getPrefixFromNamespace($this->getPrefix($typeDef['arrayType'])) . ':' . $this->getLocalPart($typeDef['arrayType']) . '[0]"/>';
				}

				$this->debug('in serializeType: returning: ' . $xml);
				return $xml;
			}

			if (isset($typeDef['multidimensional'])) {
				$nv = array();

				foreach ($value as $v) {
					$cols = ',' . sizeof($v);
					$nv = array_merge($nv, $v);
				}

				$value = $nv;
			}
			else {
				$cols = '';
			}

			if (is_array($value) && 1 <= sizeof($value)) {
				$rows = sizeof($value);
				$contents = '';

				foreach ($value as $k => $v) {
					$this->debug('serializing array element: ' . $k . ', ' . $v . ' of type: ' . $typeDef['arrayType']);

					if (!in_array($typeDef['arrayType'], $this->typemap['http://www.w3.org/2001/XMLSchema'])) {
						$contents .= $this->serializeType('item', $typeDef['arrayType'], $v, $use);
					}
					else {
						$contents .= $this->serialize_val($v, 'item', $typeDef['arrayType'], NULL, $this->XMLSchemaVersion, false, $use);
					}
				}
			}
			else {
				$rows = 0;
				$contents = NULL;
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $elementNS . '>' . $contents . ('</' . $name . '>');
			}
			else {
				$xml = '<' . $name . $elementNS . ' xsi:type="' . $this->getPrefixFromNamespace('http://schemas.xmlsoap.org/soap/encoding/') . ':Array" ' . $this->getPrefixFromNamespace('http://schemas.xmlsoap.org/soap/encoding/') . ':arrayType="' . $this->getPrefixFromNamespace($this->getPrefix($typeDef['arrayType'])) . ':' . $this->getLocalPart($typeDef['arrayType']) . ('[' . $rows . $cols . ']">') . $contents . ('</' . $name . '>');
			}
		}
		else {
			if ($phpType == 'scalar') {
				if (isset($typeDef['form']) && $typeDef['form'] == 'qualified') {
					$elementNS = ' xmlns="' . $ns . '"';
				}
				else if ($unqualified) {
					$elementNS = ' xmlns=""';
				}
				else {
					$elementNS = '';
				}

				if ($use == 'literal') {
					if ($forceType) {
						$xml = '<' . $name . $elementNS . ' xsi:type="' . $this->getPrefixFromNamespace($ns) . (':' . $uqType . '">' . $value . '</' . $name . '>');
					}
					else {
						$xml = '<' . $name . $elementNS . '>' . $value . '</' . $name . '>';
					}
				}
				else {
					$xml = '<' . $name . $elementNS . ' xsi:type="' . $this->getPrefixFromNamespace($ns) . (':' . $uqType . '"' . $encodingStyle . '>' . $value . '</' . $name . '>');
				}
			}
		}

		$this->debug('in serializeType: returning: ' . $xml);
		return $xml;
	}

	/**
	 * serializes the attributes for a complexType
	 *
	 * @param array $typeDef our internal representation of an XML schema type (or element)
	 * @param mixed $value a native PHP value (parameter value)
	 * @param string $ns the namespace of the type
	 * @param string $uqType the local part of the type
	 * @return string value serialized as an XML string
	 * @access private
	 */
	public function serializeComplexTypeAttributes($typeDef, $value, $ns, $uqType)
	{
		$this->debug('serializeComplexTypeAttributes for XML Schema type ' . $ns . ':' . $uqType);
		$xml = '';

		if (isset($typeDef['extensionBase'])) {
			$nsx = $this->getPrefix($typeDef['extensionBase']);
			$uqTypex = $this->getLocalPart($typeDef['extensionBase']);

			if ($this->getNamespaceFromPrefix($nsx)) {
				$nsx = $this->getNamespaceFromPrefix($nsx);
			}

			if ($typeDefx = $this->getTypeDef($uqTypex, $nsx)) {
				$this->debug('serialize attributes for extension base ' . $nsx . ':' . $uqTypex);
				$xml .= $this->serializeComplexTypeAttributes($typeDefx, $value, $nsx, $uqTypex);
			}
			else {
				$this->debug('extension base ' . $nsx . ':' . $uqTypex . ' is not a supported type');
			}
		}

		if (isset($typeDef['attrs']) && is_array($typeDef['attrs'])) {
			$this->debug('serialize attributes for XML Schema type ' . $ns . ':' . $uqType);

			if (is_array($value)) {
				$xvalue = $value;
			}
			else if (is_object($value)) {
				$xvalue = get_object_vars($value);
			}
			else {
				$this->debug('value is neither an array nor an object for XML Schema type ' . $ns . ':' . $uqType);
				$xvalue = array();
			}

			foreach ($typeDef['attrs'] as $aName => $attrs) {
				if (isset($xvalue['!' . $aName])) {
					$xname = '!' . $aName;
					$this->debug('value provided for attribute ' . $aName . ' with key ' . $xname);
				}
				else if (isset($xvalue[$aName])) {
					$xname = $aName;
					$this->debug('value provided for attribute ' . $aName . ' with key ' . $xname);
				}
				else if (isset($attrs['default'])) {
					$xname = '!' . $aName;
					$xvalue[$xname] = $attrs['default'];
					$this->debug('use default value of ' . $xvalue[$aName] . ' for attribute ' . $aName);
				}
				else {
					$xname = '';
					$this->debug('no value provided for attribute ' . $aName);
				}

				if ($xname) {
					$xml .= ' ' . $aName . '="' . $this->expandEntities($xvalue[$xname]) . '"';
				}
			}
		}
		else {
			$this->debug('no attributes to serialize for XML Schema type ' . $ns . ':' . $uqType);
		}

		return $xml;
	}

	/**
	 * serializes the elements for a complexType
	 *
	 * @param array $typeDef our internal representation of an XML schema type (or element)
	 * @param mixed $value a native PHP value (parameter value)
	 * @param string $ns the namespace of the type
	 * @param string $uqType the local part of the type
	 * @param string $use use for part (encoded|literal)
	 * @param string $encodingStyle SOAP encoding style for the value (if different than the enclosing style)
	 * @return string value serialized as an XML string
	 * @access private
	 */
	public function serializeComplexTypeElements($typeDef, $value, $ns, $uqType, $use = 'encoded', $encodingStyle = false)
	{
		$this->debug('in serializeComplexTypeElements for XML Schema type ' . $ns . ':' . $uqType);
		$xml = '';

		if (isset($typeDef['extensionBase'])) {
			$nsx = $this->getPrefix($typeDef['extensionBase']);
			$uqTypex = $this->getLocalPart($typeDef['extensionBase']);

			if ($this->getNamespaceFromPrefix($nsx)) {
				$nsx = $this->getNamespaceFromPrefix($nsx);
			}

			if ($typeDefx = $this->getTypeDef($uqTypex, $nsx)) {
				$this->debug('serialize elements for extension base ' . $nsx . ':' . $uqTypex);
				$xml .= $this->serializeComplexTypeElements($typeDefx, $value, $nsx, $uqTypex, $use, $encodingStyle);
			}
			else {
				$this->debug('extension base ' . $nsx . ':' . $uqTypex . ' is not a supported type');
			}
		}

		if (isset($typeDef['elements']) && is_array($typeDef['elements'])) {
			$this->debug('in serializeComplexTypeElements, serialize elements for XML Schema type ' . $ns . ':' . $uqType);

			if (is_array($value)) {
				$xvalue = $value;
			}
			else if (is_object($value)) {
				$xvalue = get_object_vars($value);
			}
			else {
				$this->debug('value is neither an array nor an object for XML Schema type ' . $ns . ':' . $uqType);
				$xvalue = array();
			}

			if (count($typeDef['elements']) != count($xvalue)) {
				$optionals = true;
			}

			foreach ($typeDef['elements'] as $eName => $attrs) {
				if (!isset($xvalue[$eName])) {
					if (isset($attrs['default'])) {
						$xvalue[$eName] = $attrs['default'];
						$this->debug('use default value of ' . $xvalue[$eName] . ' for element ' . $eName);
					}
				}

				if (isset($optionals) && !isset($xvalue[$eName]) && (!isset($attrs['nillable']) || $attrs['nillable'] != 'true')) {
					if (isset($attrs['minOccurs']) && $attrs['minOccurs'] != '0') {
						$this->debug('apparent error: no value provided for element ' . $eName . ' with minOccurs=' . $attrs['minOccurs']);
					}

					$this->debug('no value provided for complexType element ' . $eName . ' and element is not nillable, so serialize nothing');
				}
				else {
					if (isset($xvalue[$eName])) {
						$v = $xvalue[$eName];
					}
					else {
						$v = NULL;
					}

					if (isset($attrs['form'])) {
						$unqualified = $attrs['form'] == 'unqualified';
					}
					else {
						$unqualified = false;
					}

					if (isset($attrs['maxOccurs']) && ($attrs['maxOccurs'] == 'unbounded' || 1 < $attrs['maxOccurs']) && isset($v) && is_array($v) && $this->isArraySimpleOrStruct($v) == 'arraySimple') {
						$vv = $v;

						foreach ($vv as $k => $v) {
							if (isset($attrs['type']) || isset($attrs['ref'])) {
								$xml .= $this->serializeType($eName, isset($attrs['type']) ? $attrs['type'] : $attrs['ref'], $v, $use, $encodingStyle, $unqualified);
							}
							else {
								$this->debug('calling serialize_val() for ' . $v . ', ' . $eName . ', false, false, false, false, ' . $use);
								$xml .= $this->serialize_val($v, $eName, false, false, false, false, $use);
							}
						}
					}
					else {
						if (is_null($v) && isset($attrs['minOccurs']) && $attrs['minOccurs'] == '0') {
						}
						else {
							if (is_null($v) && isset($attrs['nillable']) && $attrs['nillable'] == 'true') {
								$xml .= $this->serializeType($eName, isset($attrs['type']) ? $attrs['type'] : $attrs['ref'], $v, $use, $encodingStyle, $unqualified);
							}
							else {
								if (isset($attrs['type']) || isset($attrs['ref'])) {
									$xml .= $this->serializeType($eName, isset($attrs['type']) ? $attrs['type'] : $attrs['ref'], $v, $use, $encodingStyle, $unqualified);
								}
								else {
									$this->debug('calling serialize_val() for ' . $v . ', ' . $eName . ', false, false, false, false, ' . $use);
									$xml .= $this->serialize_val($v, $eName, false, false, false, false, $use);
								}
							}
						}
					}
				}
			}
		}
		else {
			$this->debug('no elements to serialize for XML Schema type ' . $ns . ':' . $uqType);
		}

		return $xml;
	}

	/**
	* adds an XML Schema complex type to the WSDL types
	*
	* @param string	$name
	* @param string $typeClass (complexType|simpleType|attribute)
	* @param string $phpType currently supported are array and struct (php assoc array)
	* @param string $compositor (all|sequence|choice)
	* @param string $restrictionBase namespace:name (http://schemas.xmlsoap.org/soap/encoding/:Array)
	* @param array $elements e.g. array ( name => array(name=>'',type=>'') )
	* @param array $attrs e.g. array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'xsd:string[]'))
	* @param string $arrayType as namespace:name (xsd:string)
	* @see nusoap_xmlschema
	* @access public
	*/
	public function addComplexType($name, $typeClass = 'complexType', $phpType = 'array', $compositor = '', $restrictionBase = '', $elements = array(), $attrs = array(), $arrayType = '')
	{
		if (0 < count($elements)) {
			$eElements = array();

			foreach ($elements as $n => $e) {
				$ee = array();

				foreach ($e as $k => $v) {
					$k = strpos($k, ':') ? $this->expandQname($k) : $k;
					$v = strpos($v, ':') ? $this->expandQname($v) : $v;
					$ee[$k] = $v;
				}

				$eElements[$n] = $ee;
			}

			$elements = $eElements;
		}

		if (0 < count($attrs)) {
			foreach ($attrs as $n => $a) {
				foreach ($a as $k => $v) {
					$k = strpos($k, ':') ? $this->expandQname($k) : $k;
					$v = strpos($v, ':') ? $this->expandQname($v) : $v;
					$aa[$k] = $v;
				}

				$eAttrs[$n] = $aa;
			}

			$attrs = $eAttrs;
		}

		$restrictionBase = strpos($restrictionBase, ':') ? $this->expandQname($restrictionBase) : $restrictionBase;
		$arrayType = strpos($arrayType, ':') ? $this->expandQname($arrayType) : $arrayType;
		$typens = isset($this->namespaces['types']) ? $this->namespaces['types'] : $this->namespaces['tns'];
		$this->schemas[$typens][0]->addComplexType($name, $typeClass, $phpType, $compositor, $restrictionBase, $elements, $attrs, $arrayType);
	}

	/**
	* adds an XML Schema simple type to the WSDL types
	*
	* @param string $name
	* @param string $restrictionBase namespace:name (http://schemas.xmlsoap.org/soap/encoding/:Array)
	* @param string $typeClass (should always be simpleType)
	* @param string $phpType (should always be scalar)
	* @param array $enumeration array of values
	* @see nusoap_xmlschema
	* @access public
	*/
	public function addSimpleType($name, $restrictionBase = '', $typeClass = 'simpleType', $phpType = 'scalar', $enumeration = array())
	{
		$restrictionBase = strpos($restrictionBase, ':') ? $this->expandQname($restrictionBase) : $restrictionBase;
		$typens = isset($this->namespaces['types']) ? $this->namespaces['types'] : $this->namespaces['tns'];
		$this->schemas[$typens][0]->addSimpleType($name, $restrictionBase, $typeClass, $phpType, $enumeration);
	}

	/**
	* adds an element to the WSDL types
	*
	* @param array $attrs attributes that must include name and type
	* @see nusoap_xmlschema
	* @access public
	*/
	public function addElement($attrs)
	{
		$typens = isset($this->namespaces['types']) ? $this->namespaces['types'] : $this->namespaces['tns'];
		$this->schemas[$typens][0]->addElement($attrs);
	}

	/**
	* register an operation with the server
	* 
	* @param string $name operation (method) name
	* @param array $in assoc array of input values: key = param name, value = param type
	* @param array $out assoc array of output values: key = param name, value = param type
	* @param string $namespace optional The namespace for the operation
	* @param string $soapaction optional The soapaction for the operation
	* @param string $style (rpc|document) optional The style for the operation Note: when 'document' is specified, parameter and return wrappers are created for you automatically
	* @param string $use (encoded|literal) optional The use for the parameters (cannot mix right now)
	* @param string $documentation optional The description to include in the WSDL
	* @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
	* @access public 
	*/
	public function addOperation($name, $in = false, $out = false, $namespace = false, $soapaction = false, $style = 'rpc', $use = 'encoded', $documentation = '', $encodingStyle = '')
	{
		if ($use == 'encoded' && $encodingStyle == '') {
			$encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/';
		}

		if ($style == 'document') {
			$elements = array();

			foreach ($in as $n => $t) {
				$elements[$n] = array('name' => $n, 'type' => $t, 'form' => 'unqualified');
			}

			$this->addComplexType($name . 'RequestType', 'complexType', 'struct', 'all', '', $elements);
			$this->addElement(array('name' => $name, 'type' => $name . 'RequestType'));
			$in = array('parameters' => 'tns:' . $name . '^');
			$elements = array();

			foreach ($out as $n => $t) {
				$elements[$n] = array('name' => $n, 'type' => $t, 'form' => 'unqualified');
			}

			$this->addComplexType($name . 'ResponseType', 'complexType', 'struct', 'all', '', $elements);
			$this->addElement(array('name' => $name . 'Response', 'type' => $name . 'ResponseType', 'form' => 'qualified'));
			$out = array('parameters' => 'tns:' . $name . 'Response' . '^');
		}

		$this->bindings[$this->serviceName . 'Binding']['operations'][$name] = array(
	'name'          => $name,
	'binding'       => $this->serviceName . 'Binding',
	'endpoint'      => $this->endpoint,
	'soapAction'    => $soapaction,
	'style'         => $style,
	'input'         => array('use' => $use, 'namespace' => $namespace, 'encodingStyle' => $encodingStyle, 'message' => $name . 'Request', 'parts' => $in),
	'output'        => array('use' => $use, 'namespace' => $namespace, 'encodingStyle' => $encodingStyle, 'message' => $name . 'Response', 'parts' => $out),
	'namespace'     => $namespace,
	'transport'     => 'http://schemas.xmlsoap.org/soap/http',
	'documentation' => $documentation
	);

		if ($in) {
			foreach ($in as $pName => $pType) {
				if (strpos($pType, ':')) {
					$pType = $this->getNamespaceFromPrefix($this->getPrefix($pType)) . ':' . $this->getLocalPart($pType);
				}

				$this->messages[$name . 'Request'][$pName] = $pType;
			}
		}
		else {
			$this->messages[$name . 'Request'] = '0';
		}

		if ($out) {
			foreach ($out as $pName => $pType) {
				if (strpos($pType, ':')) {
					$pType = $this->getNamespaceFromPrefix($this->getPrefix($pType)) . ':' . $this->getLocalPart($pType);
				}

				$this->messages[$name . 'Response'][$pName] = $pType;
			}
		}
		else {
			$this->messages[$name . 'Response'] = '0';
		}

		return true;
	}

	/**
	* constructor
	*
	* @access	public
	*/
	public function nusoap_base()
	{
		$this->debugLevel = $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* gets the global debug level, which applies to future instances
	*
	* @return	integer	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getGlobalDebugLevel()
	{
		return $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* sets the global debug level, which applies to future instances
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setGlobalDebugLevel($level)
	{
		$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = $level;
	}

	/**
	* gets the debug level for this instance
	*
	* @return	int	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}

	/**
	* sets the debug level for this instance
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}

	/**
	* adds debug data to the instance debug string with formatting
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function debug($string)
	{
		if (0 < $this->debugLevel) {
			$this->appendDebug($this->getmicrotime() . ' ' . get_class($this) . (': ' . $string . "\n"));
		}
	}

	/**
	* adds debug data to the instance debug string without formatting
	*
	* @param    string $string debug data
	* @access   public
	*/
	public function appendDebug($string)
	{
		if (0 < $this->debugLevel) {
			$this->debug_str .= $string;
		}
	}

	/**
	* clears the current debug data for this instance
	*
	* @access   public
	*/
	public function clearDebug()
	{
		$this->debug_str = '';
	}

	/**
	* gets the current debug data for this instance
	*
	* @return   debug data
	* @access   public
	*/
	public function& getDebug()
	{
		return $this->debug_str;
	}

	/**
	* gets the current debug data for this instance as an XML comment
	* this may change the contents of the debug data
	*
	* @return   debug data as an XML comment
	* @access   public
	*/
	public function& getDebugAsXMLComment()
	{
		while (strpos($this->debug_str, '--')) {
			$this->debug_str = str_replace('--', '- -', $this->debug_str);
		}

		$ret = "<!--\n" . $this->debug_str . "\n-->";
		return $ret;
	}

	/**
	* expands entities, e.g. changes '<' to '&lt;'.
	*
	* @param	string	$val	The string in which to expand entities.
	* @access	private
	*/
	public function expandEntities($val)
	{
		if ($this->charencoding) {
			$val = str_replace('&', '&amp;', $val);
			$val = str_replace('\'', '&apos;', $val);
			$val = str_replace('"', '&quot;', $val);
			$val = str_replace('<', '&lt;', $val);
			$val = str_replace('>', '&gt;', $val);
		}

		return $val;
	}

	/**
	* returns error string if present
	*
	* @return   mixed error string or false
	* @access   public
	*/
	public function getError()
	{
		if ($this->error_str != '') {
			return $this->error_str;
		}

		return false;
	}

	/**
	* sets error string
	*
	* @return   boolean $string error string
	* @access   private
	*/
	public function setError($str)
	{
		$this->error_str = $str;
	}

	/**
	* detect if array is a simple array or a struct (associative array)
	*
	* @param	mixed	$val	The PHP array
	* @return	string	(arraySimple|arrayStruct)
	* @access	private
	*/
	public function isArraySimpleOrStruct($val)
	{
		$keyList = array_keys($val);

		foreach ($keyList as $keyListValue) {
			if (!is_int($keyListValue)) {
				return 'arrayStruct';
			}
		}

		return 'arraySimple';
	}

	/**
	* serializes PHP values in accordance w/ section 5. Type information is
	* not serialized if $use == 'literal'.
	*
	* @param	mixed	$val	The value to serialize
	* @param	string	$name	The name (local part) of the XML element
	* @param	string	$type	The XML schema type (local part) for the element
	* @param	string	$name_ns	The namespace for the name of the XML element
	* @param	string	$type_ns	The namespace for the type of the element
	* @param	array	$attributes	The attributes to serialize as name=>value pairs
	* @param	string	$use	The WSDL "use" (encoded|literal)
	* @param	boolean	$soapval	Whether this is called from soapval.
	* @return	string	The serialized element, possibly with child elements
    * @access	public
	*/
	public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = 'encoded', $soapval = false)
	{
		$this->debug('in serialize_val: name=' . $name . ', type=' . $type . ', name_ns=' . $name_ns . ', type_ns=' . $type_ns . ', use=' . $use . ', soapval=' . $soapval);
		$this->appendDebug('value=' . $this->varDump($val));
		$this->appendDebug('attributes=' . $this->varDump($attributes));
		if (is_object($val) && get_class($val) == 'soapval' && !$soapval) {
			$this->debug('serialize_val: serialize soapval');
			$xml = $val->serialize($use);
			$this->appendDebug($val->getDebug());
			$val->clearDebug();
			$this->debug('serialize_val of soapval returning ' . $xml);
			return $xml;
		}

		if (is_numeric($name)) {
			$name = '__numeric_' . $name;
		}
		else {
			if (!$name) {
				$name = 'noname';
			}
		}

		$xmlns = '';

		if ($name_ns) {
			$prefix = 'nu' . rand(1000, 9999);
			$name = $prefix . ':' . $name;
			$xmlns .= ' xmlns:' . $prefix . '="' . $name_ns . '"';
		}

		if ($type_ns != '' && $type_ns == $this->namespaces['xsd']) {
			$type_prefix = 'xsd';
		}
		else {
			if ($type_ns) {
				$type_prefix = 'ns' . rand(1000, 9999);
				$xmlns .= ' xmlns:' . $type_prefix . '="' . $type_ns . '"';
			}
		}

		$atts = '';

		if ($attributes) {
			foreach ($attributes as $k => $v) {
				$atts .= ' ' . $k . '="' . $this->expandEntities($v) . '"';
			}
		}

		if (is_null($val)) {
			$this->debug('serialize_val: serialize null');

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '/>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			$xml = '<' . $name . $xmlns . $type_str . $atts . ' xsi:nil="true"/>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		if ($type != '' && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
			$this->debug('serialize_val: serialize xsd built-in primitive type');

			if (is_bool($val)) {
				if ($type == 'boolean') {
					$val = $val ? 'true' : 'false';
				}
				else {
					if (!$val) {
						$val = 0;
					}
				}
			}
			else {
				if (is_string($val)) {
					$val = $this->expandEntities($val);
				}
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			$xml = '<' . $name . $xmlns . ' xsi:type="xsd:' . $type . '"' . $atts . '>' . $val . '</' . $name . '>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		$xml = '';
		switch (true) {
		case is_bool($val) || $type == 'boolean':
			$this->debug('serialize_val: serialize boolean');

			if ($type == 'boolean') {
				$val = $val ? 'true' : 'false';
			}
			else {
				if (!$val) {
					$val = 0;
				}
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:boolean"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_int($val) || is_long($val) || $type == 'int':
			$this->debug('serialize_val: serialize int');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:int"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_float($val) || is_double($val) || $type == 'float':
			$this->debug('serialize_val: serialize float');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:float"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_string($val) || $type == 'string':
			$this->debug('serialize_val: serialize string');
			$val = $this->expandEntities($val);

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:string"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_object($val):
			$this->debug('serialize_val: serialize object');

			if (get_class($val) == 'soapval') {
				$this->debug('serialize_val: serialize soapval object');
				$pXml = $val->serialize($use);
				$this->appendDebug($val->getDebug());
				$val->clearDebug();
			}
			else {
				if (!$name) {
					$name = get_class($val);
					$this->debug('In serialize_val, used class name ' . $name . ' as element name');
				}
				else {
					$this->debug('In serialize_val, do not override name ' . $name . ' for element name for class ' . get_class($val));
				}

				foreach (get_object_vars($val) as $k => $v) {
					$pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $pXml . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . $type_str . $atts . '>' . $pXml . '</' . $name . '>';
			}

			break;

		case is_array($val) || $type:
			$valueType = $this->isArraySimpleOrStruct($val);
			if ($valueType == 'arraySimple' || preg_match('/^ArrayOf/', $type)) {
				$this->debug('serialize_val: serialize array');
				$i = 0;
				if (is_array($val) && 0 < count($val)) {
					foreach ($val as $v) {
						if (is_object($v) && get_class($v) == 'soapval') {
							$tt_ns = $v->type_ns;
							$tt = $v->type;
						}
						else if (is_array($v)) {
							$tt = $this->isArraySimpleOrStruct($v);
						}
						else {
							$tt = gettype($v);
						}

						$array_types[$tt] = 1;
						$xml .= $this->serialize_val($v, 'item', false, false, false, false, $use);
						++$i;
					}

					if (1 < count($array_types)) {
						$array_typename = 'xsd:anyType';
					}
					else {
						if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
							if ($tt == 'integer') {
								$tt = 'int';
							}

							$array_typename = 'xsd:' . $tt;
						}
						else {
							if (isset($tt) && $tt == 'arraySimple') {
								$array_typename = 'SOAP-ENC:Array';
							}
							else {
								if (isset($tt) && $tt == 'arrayStruct') {
									$array_typename = 'unnamed_struct_use_soapval';
								}
								else {
									if ($tt_ns != '' && $tt_ns == $this->namespaces['xsd']) {
										$array_typename = 'xsd:' . $tt;
									}
									else if ($tt_ns) {
										$tt_prefix = 'ns' . rand(1000, 9999);
										$array_typename = $tt_prefix . ':' . $tt;
										$xmlns .= ' xmlns:' . $tt_prefix . '="' . $tt_ns . '"';
									}
									else {
										$array_typename = $tt;
									}
								}
							}
						}
					}

					$array_type = $i;

					if ($use == 'literal') {
						$type_str = '';
					}
					else {
						if (isset($type) && isset($type_prefix)) {
							$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
						}
						else {
							$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="' . $array_typename . ('[' . $array_type . ']"');
						}
					}
				}
				else if ($use == 'literal') {
					$type_str = '';
				}
				else {
					if (isset($type) && isset($type_prefix)) {
						$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
					}
					else {
						$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="xsd:anyType[0]"';
					}
				}

				$xml = '<' . $name . $xmlns . $type_str . $atts . '>' . $xml . ('</' . $name . '>');
			}
			else {
				$this->debug('serialize_val: serialize struct');
				if (isset($type) && isset($type_prefix)) {
					$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
				}
				else {
					$type_str = '';
				}

				if ($use == 'literal') {
					$xml .= '<' . $name . $xmlns . $atts . '>';
				}
				else {
					$xml .= '<' . $name . $xmlns . $type_str . $atts . '>';
				}

				foreach ($val as $k => $v) {
					if ($type == 'Map' && $type_ns == 'http://xml.apache.org/xml-soap') {
						$xml .= '<item>';
						$xml .= $this->serialize_val($k, 'key', false, false, false, false, $use);
						$xml .= $this->serialize_val($v, 'value', false, false, false, false, $use);
						$xml .= '</item>';
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$xml .= '</' . $name . '>';
			}

			break;

		default:
			$this->debug('serialize_val: serialize unknown');
			$xml .= 'not detected, got ' . gettype($val) . ' for ' . $val;
			break;
		}

		$this->debug('serialize_val returning ' . $xml);
		return $xml;
	}

	/**
    * serializes a message
    *
    * @param string $body the XML of the SOAP body
    * @param mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
    * @param array $namespaces optional the namespaces used in generating the body and headers
    * @param string $style optional (rpc|document)
    * @param string $use optional (encoded|literal)
    * @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
    * @return string the message
    * @access public
    */
	public function serializeEnvelope($body, $headers = false, $namespaces = array(), $style = 'rpc', $use = 'encoded', $encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/')
	{
		$this->debug('In serializeEnvelope length=' . strlen($body) . ' body (max 1000 characters)=' . substr($body, 0, 1000) . (' style=' . $style . ' use=' . $use . ' encodingStyle=' . $encodingStyle));
		$this->debug('headers:');
		$this->appendDebug($this->varDump($headers));
		$this->debug('namespaces:');
		$this->appendDebug($this->varDump($namespaces));
		$ns_string = '';

		foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
			$ns_string .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if ($encodingStyle) {
			$ns_string = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"' . $ns_string;
		}

		if ($headers) {
			if (is_array($headers)) {
				$xml = '';

				foreach ($headers as $k => $v) {
					if (is_object($v) && get_class($v) == 'soapval') {
						$xml .= $this->serialize_val($v, false, false, false, false, false, $use);
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$headers = $xml;
				$this->debug('In serializeEnvelope, serialized array of headers to ' . $headers);
			}

			$headers = '<SOAP-ENV:Header>' . $headers . '</SOAP-ENV:Header>';
		}

		return '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?' . '>' . '<SOAP-ENV:Envelope' . $ns_string . '>' . $headers . '<SOAP-ENV:Body>' . $body . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
	}

	/**
	 * formats a string to be inserted into an HTML stream
	 *
	 * @param string $str The string to format
	 * @return string The formatted string
	 * @access public
	 * @deprecated
	 */
	public function formatDump($str)
	{
		$str = htmlspecialchars($str);
		return nl2br($str);
	}

	/**
	* contracts (changes namespace to prefix) a qualified name
	*
	* @param    string $qname qname
	* @return	string contracted qname
	* @access   private
	*/
	public function contractQname($qname)
	{
		if (strrpos($qname, ':')) {
			$name = substr($qname, strrpos($qname, ':') + 1);
			$ns = substr($qname, 0, strrpos($qname, ':'));
			$p = $this->getPrefixFromNamespace($ns);

			if ($p) {
				return $p . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
	* expands (changes prefix to namespace) a qualified name
	*
	* @param    string $qname qname
	* @return	string expanded qname
	* @access   private
	*/
	public function expandQname($qname)
	{
		if (strpos($qname, ':') && !preg_match('/^http:\\/\\//', $qname)) {
			$name = substr(strstr($qname, ':'), 1);
			$prefix = substr($qname, 0, strpos($qname, ':'));

			if (isset($this->namespaces[$prefix])) {
				return $this->namespaces[$prefix] . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
    * returns the local part of a prefixed string
    * returns the original string, if not prefixed
    *
    * @param string $str The prefixed string
    * @return string The local part
    * @access public
    */
	public function getLocalPart($str)
	{
		if ($sstr = strrchr($str, ':')) {
			return substr($sstr, 1);
		}

		return $str;
	}

	/**
    * returns the prefix part of a prefixed string
    * returns false, if not prefixed
    *
    * @param string $str The prefixed string
    * @return mixed The prefix or false if there is no prefix
    * @access public
    */
	public function getPrefix($str)
	{
		if ($pos = strrpos($str, ':')) {
			return substr($str, 0, $pos);
		}

		return false;
	}

	/**
    * pass it a prefix, it returns a namespace
    *
    * @param string $prefix The prefix
    * @return mixed The namespace, false if no namespace has the specified prefix
    * @access public
    */
	public function getNamespaceFromPrefix($prefix)
	{
		if (isset($this->namespaces[$prefix])) {
			return $this->namespaces[$prefix];
		}

		return false;
	}

	/**
    * returns the prefix for a given namespace (or prefix)
    * or false if no prefixes registered for the given namespace
    *
    * @param string $ns The namespace
    * @return mixed The prefix, false if the namespace has no prefixes
    * @access public
    */
	public function getPrefixFromNamespace($ns)
	{
		foreach ($this->namespaces as $p => $n) {
			if ($ns == $n || $ns == $p) {
				$this->usedNamespaces[$p] = $n;
				return $p;
			}
		}

		return false;
	}

	/**
    * returns the time in ODBC canonical form with microseconds
    *
    * @return string The time in ODBC canonical form with microseconds
    * @access public
    */
	public function getmicrotime()
	{
		if (function_exists('gettimeofday')) {
			$tod = gettimeofday();
			$sec = $tod['sec'];
			$usec = $tod['usec'];
		}
		else {
			$sec = time();
			$usec = 0;
		}

		return strftime('%Y-%m-%d %H:%M:%S', $sec) . '.' . sprintf('%06d', $usec);
	}

	/**
	 * Returns a string with the output of var_dump
	 *
	 * @param mixed $data The variable to var_dump
	 * @return string The output of var_dump
	 * @access public
	 */
	public function varDump($data)
	{
		ob_start();
		var_dump($data);
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	/**
	* represents the object as a string
	*
	* @return	string
	* @access   public
	*/
	public function __toString()
	{
		return $this->varDump($this);
	}
}

class nusoap_parser extends nusoap_base
{
	public $xml = '';
	public $xml_encoding = '';
	public $method = '';
	public $root_struct = '';
	public $root_struct_name = '';
	public $root_struct_namespace = '';
	public $root_header = '';
	public $document = '';
	public $status = '';
	public $position = 0;
	public $depth = 0;
	public $default_namespace = '';
	public $namespaces = array();
	public $message = array();
	public $parent = '';
	public $fault = false;
	public $fault_code = '';
	public $fault_str = '';
	public $fault_detail = '';
	public $depth_array = array();
	public $debug_flag = true;
	public $soapresponse;
	public $soapheader;
	public $responseHeaders = '';
	public $body_position = 0;
	public $ids = array();
	public $multirefs = array();
	public $decode_utf8 = true;
	/**
	 * Identification for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $title = 'NuSOAP';
	/**
	 * Version for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $version = '0.9.5';
	/**
	 * CVS revision for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $revision = '$Revision: 1.123 $';
	/**
     * Current error string (manipulated by getError/setError)
	 *
	 * @var string
	 * @access private
	 */
	public $error_str = '';
	/**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
	 *
	 * @var string
	 * @access private
	 */
	public $debug_str = '';
	/**
	 * toggles automatic encoding of special characters as entities
	 * (should always be true, I think)
	 *
	 * @var boolean
	 * @access private
	 */
	public $charencoding = true;
	/**
	 * the debug level for this instance
	 *
	 * @var	integer
	 * @access private
	 */
	public $debugLevel;
	/**
	* set schema version
	*
	* @var      string
	* @access   public
	*/
	public $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';
	/**
	* charset encoding for outgoing messages
	*
	* @var      string
	* @access   public
	*/
	public $soap_defencoding = 'ISO-8859-1';
	/**
	* namespaces used in the current context, e.g. during serialization
	*
	* @var      array
	* @access   private
	*/
	public $usedNamespaces = array();
	/**
	* XML Schema types in an array of uri => (array of xml type => php type)
	* is this legacy yet?
	* no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
	* @var      array
	* @access   public
	*/
	public $typemap = array(
		'http://www.w3.org/2001/XMLSchema'          => array('string' => 'string', 'boolean' => 'boolean', 'float' => 'double', 'double' => 'double', 'decimal' => 'double', 'duration' => '', 'dateTime' => 'string', 'time' => 'string', 'date' => 'string', 'gYearMonth' => '', 'gYear' => '', 'gMonthDay' => '', 'gDay' => '', 'gMonth' => '', 'hexBinary' => 'string', 'base64Binary' => 'string', 'anyType' => 'string', 'anySimpleType' => 'string', 'normalizedString' => 'string', 'token' => 'string', 'language' => '', 'NMTOKEN' => '', 'NMTOKENS' => '', 'Name' => '', 'NCName' => '', 'ID' => '', 'IDREF' => '', 'IDREFS' => '', 'ENTITY' => '', 'ENTITIES' => '', 'integer' => 'integer', 'nonPositiveInteger' => 'integer', 'negativeInteger' => 'integer', 'long' => 'integer', 'int' => 'integer', 'short' => 'integer', 'byte' => 'integer', 'nonNegativeInteger' => 'integer', 'unsignedLong' => '', 'unsignedInt' => '', 'unsignedShort' => '', 'unsignedByte' => '', 'positiveInteger' => ''),
		'http://www.w3.org/2000/10/XMLSchema'       => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://www.w3.org/1999/XMLSchema'          => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://soapinterop.org/xsd'                => array('SOAPStruct' => 'struct'),
		'http://schemas.xmlsoap.org/soap/encoding/' => array('base64' => 'string', 'array' => 'array', 'Array' => 'array'),
		'http://xml.apache.org/xml-soap'            => array('Map')
		);
	/**
	* XML entities to convert
	*
	* @var      array
	* @access   public
	* @deprecated
	* @see	expandEntities
	*/
	public $xmlEntities = array('quot' => '"', 'amp' => '&', 'lt' => '<', 'gt' => '>', 'apos' => '\'');

	/**
	* constructor that actually does the parsing
	*
	* @param    string $xml SOAP message
	* @param    string $encoding character encoding scheme of message
	* @param    string $method method for which XML is parsed (unused?)
	* @param    string $decode_utf8 whether to decode UTF-8 to ISO-8859-1
	* @access   public
	*/
	public function nusoap_parser($xml, $encoding = 'UTF-8', $method = '', $decode_utf8 = true)
	{
		parent::nusoap_base();
		$this->xml = $xml;
		$this->xml_encoding = $encoding;
		$this->method = $method;
		$this->decode_utf8 = $decode_utf8;

		if (!empty($xml)) {
			$pos_xml = strpos($xml, '<?xml');

			if ($pos_xml !== false) {
				$xml_decl = substr($xml, $pos_xml, strpos($xml, '?>', $pos_xml + 2) - $pos_xml + 1);

				if (preg_match('/encoding=["\']([^"\']*)["\']/', $xml_decl, $res)) {
					$xml_encoding = $res[1];

					if (strtoupper($xml_encoding) != $encoding) {
						$err = 'Charset from HTTP Content-Type \'' . $encoding . '\' does not match encoding from XML declaration \'' . $xml_encoding . '\'';
						$this->debug($err);
						if ($encoding != 'ISO-8859-1' || strtoupper($xml_encoding) != 'UTF-8') {
							$this->setError($err);
							return NULL;
						}
					}
					else {
						$this->debug('Charset from HTTP Content-Type matches encoding from XML declaration');
					}
				}
				else {
					$this->debug('No encoding specified in XML declaration');
				}
			}
			else {
				$this->debug('No XML declaration');
			}

			$this->debug('Entering nusoap_parser(), length=' . strlen($xml) . ', encoding=' . $encoding);
			$this->parser = xml_parser_create($this->xml_encoding);
			xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);
			xml_parser_set_option($this->parser, XML_OPTION_TARGET_ENCODING, $this->xml_encoding);
			xml_set_object($this->parser, $this);
			xml_set_element_handler($this->parser, 'start_element', 'end_element');
			xml_set_character_data_handler($this->parser, 'character_data');

			if (!xml_parse($this->parser, $xml, true)) {
				$err = sprintf('XML error parsing SOAP payload on line %d: %s', xml_get_current_line_number($this->parser), xml_error_string(xml_get_error_code($this->parser)));
				$this->debug($err);
				$this->debug("XML payload:\n" . $xml);
				$this->setError($err);
			}
			else {
				$this->debug('in nusoap_parser ctor, message:');
				$this->appendDebug($this->varDump($this->message));
				$this->debug('parsed successfully, found root struct: ' . $this->root_struct . ' of name ' . $this->root_struct_name);
				$this->soapresponse = $this->message[$this->root_struct]['result'];
				if ($this->root_header != '' && isset($this->message[$this->root_header]['result'])) {
					$this->soapheader = $this->message[$this->root_header]['result'];
				}

				if (0 < sizeof($this->multirefs)) {
					foreach ($this->multirefs as $id => $hrefs) {
						$this->debug('resolving multirefs for id: ' . $id);
						$idVal = $this->buildVal($this->ids[$id]);
						if (is_array($idVal) && isset($idVal['!id'])) {
							unset($idVal['!id']);
						}

						foreach ($hrefs as $refPos => $ref) {
							$this->debug('resolving href at pos ' . $refPos);
							$this->multirefs[$id][$refPos] = $idVal;
						}
					}
				}
			}

			xml_parser_free($this->parser);
			return NULL;
		}

		$this->debug('xml was empty, didn\'t parse!');
		$this->setError('xml was empty, didn\'t parse!');
	}

	/**
	* start-element handler
	*
	* @param    resource $parser XML parser object
	* @param    string $name element name
	* @param    array $attrs associative array of attributes
	* @access   private
	*/
	public function start_element($parser, $name, $attrs)
	{
		$pos = $this->position++;
		$this->message[$pos] = array('pos' => $pos, 'children' => '', 'cdata' => '');
		$this->message[$pos]['depth'] = $this->depth++;

		if ($pos != 0) {
			$this->message[$this->parent]['children'] .= '|' . $pos;
		}

		$this->message[$pos]['parent'] = $this->parent;
		$this->parent = $pos;
		$this->depth_array[$this->depth] = $pos;

		if (strpos($name, ':')) {
			$prefix = substr($name, 0, strpos($name, ':'));
			$name = substr(strstr($name, ':'), 1);
		}

		if ($name == 'Envelope' && $this->status == '') {
			$this->status = 'envelope';
		}
		else {
			if ($name == 'Header' && $this->status == 'envelope') {
				$this->root_header = $pos;
				$this->status = 'header';
			}
			else {
				if ($name == 'Body' && $this->status == 'envelope') {
					$this->status = 'body';
					$this->body_position = $pos;
				}
				else {
					if ($this->status == 'body' && $pos == $this->body_position + 1) {
						$this->status = 'method';
						$this->root_struct_name = $name;
						$this->root_struct = $pos;
						$this->message[$pos]['type'] = 'struct';
						$this->debug('found root struct ' . $this->root_struct_name . ', pos ' . $this->root_struct);
					}
				}
			}
		}

		$this->message[$pos]['status'] = $this->status;
		$this->message[$pos]['name'] = htmlspecialchars($name);
		$this->message[$pos]['attrs'] = $attrs;
		$attstr = '';

		foreach ($attrs as $key => $value) {
			$key_prefix = $this->getPrefix($key);
			$key_localpart = $this->getLocalPart($key);

			if ($key_prefix == 'xmlns') {
				if (preg_match('/^http:\\/\\/www.w3.org\\/[0-9]{4}\\/XMLSchema$/', $value)) {
					$this->XMLSchemaVersion = $value;
					$this->namespaces['xsd'] = $this->XMLSchemaVersion;
					$this->namespaces['xsi'] = $this->XMLSchemaVersion . '-instance';
				}

				$this->namespaces[$key_localpart] = $value;

				if ($name == $this->root_struct_name) {
					$this->methodNamespace = $value;
				}
			}
			else if ($key_localpart == 'type') {
				if (isset($this->message[$pos]['type']) && $this->message[$pos]['type'] == 'array') {
				}
				else {
					$value_prefix = $this->getPrefix($value);
					$value_localpart = $this->getLocalPart($value);
					$this->message[$pos]['type'] = $value_localpart;
					$this->message[$pos]['typePrefix'] = $value_prefix;

					if (isset($this->namespaces[$value_prefix])) {
						$this->message[$pos]['type_namespace'] = $this->namespaces[$value_prefix];
					}
					else {
						if (isset($attrs['xmlns:' . $value_prefix])) {
							$this->message[$pos]['type_namespace'] = $attrs['xmlns:' . $value_prefix];
						}
					}
				}
			}
			else if ($key_localpart == 'arrayType') {
				$this->message[$pos]['type'] = 'array';
				$expr = '/([A-Za-z0-9_]+):([A-Za-z]+[A-Za-z0-9_]+)\\[([0-9]+),?([0-9]*)\\]/';

				if (preg_match($expr, $value, $regs)) {
					$this->message[$pos]['typePrefix'] = $regs[1];
					$this->message[$pos]['arrayTypePrefix'] = $regs[1];

					if (isset($this->namespaces[$regs[1]])) {
						$this->message[$pos]['arrayTypeNamespace'] = $this->namespaces[$regs[1]];
					}
					else {
						if (isset($attrs['xmlns:' . $regs[1]])) {
							$this->message[$pos]['arrayTypeNamespace'] = $attrs['xmlns:' . $regs[1]];
						}
					}

					$this->message[$pos]['arrayType'] = $regs[2];
					$this->message[$pos]['arraySize'] = $regs[3];
					$this->message[$pos]['arrayCols'] = $regs[4];
				}
			}
			else if ($key_localpart == 'nil') {
				$this->message[$pos]['nil'] = $value == 'true' || $value == '1';
			}
			else {
				if ($key != 'href' && $key != 'xmlns' && $key_localpart != 'encodingStyle' && $key_localpart != 'root') {
					$this->message[$pos]['xattrs']['!' . $key] = $value;
				}
			}

			if ($key == 'xmlns') {
				$this->default_namespace = $value;
			}

			if ($key == 'id') {
				$this->ids[$value] = $pos;
			}

			if ($key_localpart == 'root' && $value == 1) {
				$this->status = 'method';
				$this->root_struct_name = $name;
				$this->root_struct = $pos;
				$this->debug('found root struct ' . $this->root_struct_name . ', pos ' . $pos);
			}

			$attstr .= ' ' . $key . '="' . $value . '"';
		}

		if (isset($prefix)) {
			$this->message[$pos]['namespace'] = $this->namespaces[$prefix];
			$this->default_namespace = $this->namespaces[$prefix];
		}
		else {
			$this->message[$pos]['namespace'] = $this->default_namespace;
		}

		if ($this->status == 'header') {
			if ($this->root_header != $pos) {
				$this->responseHeaders .= '<' . (isset($prefix) ? $prefix . ':' : '') . ($name . $attstr . '>');
				return NULL;
			}
		}
		else {
			if ($this->root_struct_name != '') {
				$this->document .= '<' . (isset($prefix) ? $prefix . ':' : '') . ($name . $attstr . '>');
			}
		}
	}

	/**
	* end-element handler
	*
	* @param    resource $parser XML parser object
	* @param    string $name element name
	* @access   private
	*/
	public function end_element($parser, $name)
	{
		$pos = $this->depth_array[$this->depth--];

		if (strpos($name, ':')) {
			$prefix = substr($name, 0, strpos($name, ':'));
			$name = substr(strstr($name, ':'), 1);
		}

		if (isset($this->body_position) && $this->body_position < $pos) {
			if (isset($this->message[$pos]['attrs']['href'])) {
				$id = substr($this->message[$pos]['attrs']['href'], 1);
				$this->multirefs[$id][$pos] = 'placeholder';
				$this->message[$pos]['result'] = &$this->multirefs[$id][$pos];
			}
			else if ($this->message[$pos]['children'] != '') {
				if (!isset($this->message[$pos]['result'])) {
					$this->message[$pos]['result'] = $this->buildVal($pos);
				}
			}
			else if (isset($this->message[$pos]['xattrs'])) {
				if (isset($this->message[$pos]['nil']) && $this->message[$pos]['nil']) {
					$this->message[$pos]['xattrs']['!'] = NULL;
				}
				else {
					if (isset($this->message[$pos]['cdata']) && trim($this->message[$pos]['cdata']) != '') {
						if (isset($this->message[$pos]['type'])) {
							$this->message[$pos]['xattrs']['!'] = $this->decodeSimple($this->message[$pos]['cdata'], $this->message[$pos]['type'], isset($this->message[$pos]['type_namespace']) ? $this->message[$pos]['type_namespace'] : '');
						}
						else {
							$parent = $this->message[$pos]['parent'];
							if (isset($this->message[$parent]['type']) && $this->message[$parent]['type'] == 'array' && isset($this->message[$parent]['arrayType'])) {
								$this->message[$pos]['xattrs']['!'] = $this->decodeSimple($this->message[$pos]['cdata'], $this->message[$parent]['arrayType'], isset($this->message[$parent]['arrayTypeNamespace']) ? $this->message[$parent]['arrayTypeNamespace'] : '');
							}
							else {
								$this->message[$pos]['xattrs']['!'] = $this->message[$pos]['cdata'];
							}
						}
					}
				}

				$this->message[$pos]['result'] = $this->message[$pos]['xattrs'];
			}
			else {
				if (isset($this->message[$pos]['nil']) && $this->message[$pos]['nil']) {
					$this->message[$pos]['xattrs']['!'] = NULL;
				}
				else if (isset($this->message[$pos]['type'])) {
					$this->message[$pos]['result'] = $this->decodeSimple($this->message[$pos]['cdata'], $this->message[$pos]['type'], isset($this->message[$pos]['type_namespace']) ? $this->message[$pos]['type_namespace'] : '');
				}
				else {
					$parent = $this->message[$pos]['parent'];
					if (isset($this->message[$parent]['type']) && $this->message[$parent]['type'] == 'array' && isset($this->message[$parent]['arrayType'])) {
						$this->message[$pos]['result'] = $this->decodeSimple($this->message[$pos]['cdata'], $this->message[$parent]['arrayType'], isset($this->message[$parent]['arrayTypeNamespace']) ? $this->message[$parent]['arrayTypeNamespace'] : '');
					}
					else {
						$this->message[$pos]['result'] = $this->message[$pos]['cdata'];
					}
				}
			}
		}

		if ($this->status == 'header') {
			if ($this->root_header != $pos) {
				$this->responseHeaders .= '</' . (isset($prefix) ? $prefix . ':' : '') . ($name . '>');
			}
		}
		else {
			if ($this->root_struct <= $pos) {
				$this->document .= '</' . (isset($prefix) ? $prefix . ':' : '') . ($name . '>');
			}
		}

		if ($pos == $this->root_struct) {
			$this->status = 'body';
			$this->root_struct_namespace = $this->message[$pos]['namespace'];
		}
		else if ($pos == $this->root_header) {
			$this->status = 'envelope';
		}
		else {
			if ($name == 'Body' && $this->status == 'body') {
				$this->status = 'envelope';
			}
			else {
				if ($name == 'Header' && $this->status == 'header') {
					$this->status = 'envelope';
				}
				else {
					if ($name == 'Envelope' && $this->status == 'envelope') {
						$this->status = '';
					}
				}
			}
		}

		$this->parent = $this->message[$pos]['parent'];
	}

	/**
	* element content handler
	*
	* @param    resource $parser XML parser object
	* @param    string $data element content
	* @access   private
	*/
	public function character_data($parser, $data)
	{
		$pos = $this->depth_array[$this->depth];

		if ($this->xml_encoding == 'UTF-8') {
			if ($this->decode_utf8) {
				$data = utf8_decode($data);
			}
		}

		$this->message[$pos]['cdata'] .= $data;

		if ($this->status == 'header') {
			$this->responseHeaders .= $data;
			return NULL;
		}

		$this->document .= $data;
	}

	/**
	* get the parsed message (SOAP Body)
	*
	* @return	mixed
	* @access   public
	* @deprecated	use get_soapbody instead
	*/
	public function get_response()
	{
		return $this->soapresponse;
	}

	/**
	* get the parsed SOAP Body (NULL if there was none)
	*
	* @return	mixed
	* @access   public
	*/
	public function get_soapbody()
	{
		return $this->soapresponse;
	}

	/**
	* get the parsed SOAP Header (NULL if there was none)
	*
	* @return	mixed
	* @access   public
	*/
	public function get_soapheader()
	{
		return $this->soapheader;
	}

	/**
	* get the unparsed SOAP Header
	*
	* @return	string XML or empty if no Header
	* @access   public
	*/
	public function getHeaders()
	{
		return $this->responseHeaders;
	}

	/**
	* decodes simple types into PHP variables
	*
	* @param    string $value value to decode
	* @param    string $type XML type to decode
	* @param    string $typens XML type namespace to decode
	* @return	mixed PHP value
	* @access   private
	*/
	public function decodeSimple($value, $type, $typens)
	{
		if (!isset($type) || $type == 'string' || $type == 'long' || $type == 'unsignedLong') {
			return (string) $value;
		}

		if ($type == 'int' || $type == 'integer' || $type == 'short' || $type == 'byte') {
			return (int) $value;
		}

		if ($type == 'float' || $type == 'double' || $type == 'decimal') {
			return (double) $value;
		}

		if ($type == 'boolean') {
			if (strtolower($value) == 'false' || strtolower($value) == 'f') {
				return false;
			}

			return (bool) $value;
		}

		if ($type == 'base64' || $type == 'base64Binary') {
			$this->debug('Decode base64 value');
			return base64_decode($value);
		}

		if ($type == 'nonPositiveInteger' || $type == 'negativeInteger' || $type == 'nonNegativeInteger' || $type == 'positiveInteger' || $type == 'unsignedInt' || $type == 'unsignedShort' || $type == 'unsignedByte') {
			return (int) $value;
		}

		if ($type == 'array') {
			return array();
		}

		return (string) $value;
	}

	/**
	* builds response structures for compound values (arrays/structs)
	* and scalars
	*
	* @param    integer $pos position in node tree
	* @return	mixed	PHP value
	* @access   private
	*/
	public function buildVal($pos)
	{
		if (!isset($this->message[$pos]['type'])) {
			$this->message[$pos]['type'] = '';
		}

		$this->debug('in buildVal() for ' . $this->message[$pos]['name'] . ('(pos ' . $pos . ') of type ') . $this->message[$pos]['type']);

		if ($this->message[$pos]['children'] != '') {
			$this->debug('in buildVal, there are children');
			$children = explode('|', $this->message[$pos]['children']);
			array_shift($children);
			if (isset($this->message[$pos]['arrayCols']) && $this->message[$pos]['arrayCols'] != '') {
				$r = 0;
				$c = 0;

				foreach ($children as $child_pos) {
					$this->debug('in buildVal, got an MD array element: ' . $r . ', ' . $c);
					$params[$r][] = $this->message[$child_pos]['result'];
					++$c;

					if ($c == $this->message[$pos]['arrayCols']) {
						$c = 0;
						++$r;
					}
				}
			}
			else {
				if ($this->message[$pos]['type'] == 'array' || $this->message[$pos]['type'] == 'Array') {
					$this->debug('in buildVal, adding array ' . $this->message[$pos]['name']);

					foreach ($children as $child_pos) {
						$params[] = &$this->message[$child_pos]['result'];
					}
				}
				else {
					if ($this->message[$pos]['type'] == 'Map' && $this->message[$pos]['type_namespace'] == 'http://xml.apache.org/xml-soap') {
						$this->debug('in buildVal, Java Map ' . $this->message[$pos]['name']);

						foreach ($children as $child_pos) {
							$kv = explode('|', $this->message[$child_pos]['children']);
							$params[$this->message[$kv[1]]['result']] = &$this->message[$kv[2]]['result'];
						}
					}
					else {
						$this->debug('in buildVal, adding Java Vector or generic compound type ' . $this->message[$pos]['name']);
						if ($this->message[$pos]['type'] == 'Vector' && $this->message[$pos]['type_namespace'] == 'http://xml.apache.org/xml-soap') {
							$notstruct = 1;
						}
						else {
							$notstruct = 0;
						}

						foreach ($children as $child_pos) {
							if ($notstruct) {
								$params[] = &$this->message[$child_pos]['result'];
							}
							else if (isset($params[$this->message[$child_pos]['name']])) {
								if (!is_array($params[$this->message[$child_pos]['name']]) || !isset($params[$this->message[$child_pos]['name']][0])) {
									$params[$this->message[$child_pos]['name']] = array($params[$this->message[$child_pos]['name']]);
								}

								$params[$this->message[$child_pos]['name']][] = &$this->message[$child_pos]['result'];
							}
							else {
								$params[$this->message[$child_pos]['name']] = &$this->message[$child_pos]['result'];
							}
						}
					}
				}
			}

			if (isset($this->message[$pos]['xattrs'])) {
				$this->debug('in buildVal, handling attributes');

				foreach ($this->message[$pos]['xattrs'] as $n => $v) {
					$params[$n] = $v;
				}
			}

			if (isset($this->message[$pos]['cdata']) && trim($this->message[$pos]['cdata']) != '') {
				$this->debug('in buildVal, handling simpleContent');

				if (isset($this->message[$pos]['type'])) {
					$params['!'] = $this->decodeSimple($this->message[$pos]['cdata'], $this->message[$pos]['type'], isset($this->message[$pos]['type_namespace']) ? $this->message[$pos]['type_namespace'] : '');
				}
				else {
					$parent = $this->message[$pos]['parent'];
					if (isset($this->message[$parent]['type']) && $this->message[$parent]['type'] == 'array' && isset($this->message[$parent]['arrayType'])) {
						$params['!'] = $this->decodeSimple($this->message[$pos]['cdata'], $this->message[$parent]['arrayType'], isset($this->message[$parent]['arrayTypeNamespace']) ? $this->message[$parent]['arrayTypeNamespace'] : '');
					}
					else {
						$params['!'] = $this->message[$pos]['cdata'];
					}
				}
			}

			$ret = is_array($params) ? $params : array();
			$this->debug('in buildVal, return:');
			$this->appendDebug($this->varDump($ret));
			return $ret;
		}

		$this->debug('in buildVal, no children, building scalar');
		$cdata = isset($this->message[$pos]['cdata']) ? $this->message[$pos]['cdata'] : '';

		if (isset($this->message[$pos]['type'])) {
			$ret = $this->decodeSimple($cdata, $this->message[$pos]['type'], isset($this->message[$pos]['type_namespace']) ? $this->message[$pos]['type_namespace'] : '');
			$this->debug('in buildVal, return: ' . $ret);
			return $ret;
		}

		$parent = $this->message[$pos]['parent'];
		if (isset($this->message[$parent]['type']) && $this->message[$parent]['type'] == 'array' && isset($this->message[$parent]['arrayType'])) {
			$ret = $this->decodeSimple($cdata, $this->message[$parent]['arrayType'], isset($this->message[$parent]['arrayTypeNamespace']) ? $this->message[$parent]['arrayTypeNamespace'] : '');
			$this->debug('in buildVal, return: ' . $ret);
			return $ret;
		}

		$ret = $this->message[$pos]['cdata'];
		$this->debug('in buildVal, return: ' . $ret);
		return $ret;
	}

	/**
	* constructor
	*
	* @access	public
	*/
	public function nusoap_base()
	{
		$this->debugLevel = $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* gets the global debug level, which applies to future instances
	*
	* @return	integer	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getGlobalDebugLevel()
	{
		return $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* sets the global debug level, which applies to future instances
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setGlobalDebugLevel($level)
	{
		$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = $level;
	}

	/**
	* gets the debug level for this instance
	*
	* @return	int	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}

	/**
	* sets the debug level for this instance
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}

	/**
	* adds debug data to the instance debug string with formatting
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function debug($string)
	{
		if (0 < $this->debugLevel) {
			$this->appendDebug($this->getmicrotime() . ' ' . get_class($this) . (': ' . $string . "\n"));
		}
	}

	/**
	* adds debug data to the instance debug string without formatting
	*
	* @param    string $string debug data
	* @access   public
	*/
	public function appendDebug($string)
	{
		if (0 < $this->debugLevel) {
			$this->debug_str .= $string;
		}
	}

	/**
	* clears the current debug data for this instance
	*
	* @access   public
	*/
	public function clearDebug()
	{
		$this->debug_str = '';
	}

	/**
	* gets the current debug data for this instance
	*
	* @return   debug data
	* @access   public
	*/
	public function& getDebug()
	{
		return $this->debug_str;
	}

	/**
	* gets the current debug data for this instance as an XML comment
	* this may change the contents of the debug data
	*
	* @return   debug data as an XML comment
	* @access   public
	*/
	public function& getDebugAsXMLComment()
	{
		while (strpos($this->debug_str, '--')) {
			$this->debug_str = str_replace('--', '- -', $this->debug_str);
		}

		$ret = "<!--\n" . $this->debug_str . "\n-->";
		return $ret;
	}

	/**
	* expands entities, e.g. changes '<' to '&lt;'.
	*
	* @param	string	$val	The string in which to expand entities.
	* @access	private
	*/
	public function expandEntities($val)
	{
		if ($this->charencoding) {
			$val = str_replace('&', '&amp;', $val);
			$val = str_replace('\'', '&apos;', $val);
			$val = str_replace('"', '&quot;', $val);
			$val = str_replace('<', '&lt;', $val);
			$val = str_replace('>', '&gt;', $val);
		}

		return $val;
	}

	/**
	* returns error string if present
	*
	* @return   mixed error string or false
	* @access   public
	*/
	public function getError()
	{
		if ($this->error_str != '') {
			return $this->error_str;
		}

		return false;
	}

	/**
	* sets error string
	*
	* @return   boolean $string error string
	* @access   private
	*/
	public function setError($str)
	{
		$this->error_str = $str;
	}

	/**
	* detect if array is a simple array or a struct (associative array)
	*
	* @param	mixed	$val	The PHP array
	* @return	string	(arraySimple|arrayStruct)
	* @access	private
	*/
	public function isArraySimpleOrStruct($val)
	{
		$keyList = array_keys($val);

		foreach ($keyList as $keyListValue) {
			if (!is_int($keyListValue)) {
				return 'arrayStruct';
			}
		}

		return 'arraySimple';
	}

	/**
	* serializes PHP values in accordance w/ section 5. Type information is
	* not serialized if $use == 'literal'.
	*
	* @param	mixed	$val	The value to serialize
	* @param	string	$name	The name (local part) of the XML element
	* @param	string	$type	The XML schema type (local part) for the element
	* @param	string	$name_ns	The namespace for the name of the XML element
	* @param	string	$type_ns	The namespace for the type of the element
	* @param	array	$attributes	The attributes to serialize as name=>value pairs
	* @param	string	$use	The WSDL "use" (encoded|literal)
	* @param	boolean	$soapval	Whether this is called from soapval.
	* @return	string	The serialized element, possibly with child elements
    * @access	public
	*/
	public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = 'encoded', $soapval = false)
	{
		$this->debug('in serialize_val: name=' . $name . ', type=' . $type . ', name_ns=' . $name_ns . ', type_ns=' . $type_ns . ', use=' . $use . ', soapval=' . $soapval);
		$this->appendDebug('value=' . $this->varDump($val));
		$this->appendDebug('attributes=' . $this->varDump($attributes));
		if (is_object($val) && get_class($val) == 'soapval' && !$soapval) {
			$this->debug('serialize_val: serialize soapval');
			$xml = $val->serialize($use);
			$this->appendDebug($val->getDebug());
			$val->clearDebug();
			$this->debug('serialize_val of soapval returning ' . $xml);
			return $xml;
		}

		if (is_numeric($name)) {
			$name = '__numeric_' . $name;
		}
		else {
			if (!$name) {
				$name = 'noname';
			}
		}

		$xmlns = '';

		if ($name_ns) {
			$prefix = 'nu' . rand(1000, 9999);
			$name = $prefix . ':' . $name;
			$xmlns .= ' xmlns:' . $prefix . '="' . $name_ns . '"';
		}

		if ($type_ns != '' && $type_ns == $this->namespaces['xsd']) {
			$type_prefix = 'xsd';
		}
		else {
			if ($type_ns) {
				$type_prefix = 'ns' . rand(1000, 9999);
				$xmlns .= ' xmlns:' . $type_prefix . '="' . $type_ns . '"';
			}
		}

		$atts = '';

		if ($attributes) {
			foreach ($attributes as $k => $v) {
				$atts .= ' ' . $k . '="' . $this->expandEntities($v) . '"';
			}
		}

		if (is_null($val)) {
			$this->debug('serialize_val: serialize null');

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '/>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			$xml = '<' . $name . $xmlns . $type_str . $atts . ' xsi:nil="true"/>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		if ($type != '' && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
			$this->debug('serialize_val: serialize xsd built-in primitive type');

			if (is_bool($val)) {
				if ($type == 'boolean') {
					$val = $val ? 'true' : 'false';
				}
				else {
					if (!$val) {
						$val = 0;
					}
				}
			}
			else {
				if (is_string($val)) {
					$val = $this->expandEntities($val);
				}
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			$xml = '<' . $name . $xmlns . ' xsi:type="xsd:' . $type . '"' . $atts . '>' . $val . '</' . $name . '>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		$xml = '';
		switch (true) {
		case is_bool($val) || $type == 'boolean':
			$this->debug('serialize_val: serialize boolean');

			if ($type == 'boolean') {
				$val = $val ? 'true' : 'false';
			}
			else {
				if (!$val) {
					$val = 0;
				}
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:boolean"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_int($val) || is_long($val) || $type == 'int':
			$this->debug('serialize_val: serialize int');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:int"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_float($val) || is_double($val) || $type == 'float':
			$this->debug('serialize_val: serialize float');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:float"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_string($val) || $type == 'string':
			$this->debug('serialize_val: serialize string');
			$val = $this->expandEntities($val);

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:string"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_object($val):
			$this->debug('serialize_val: serialize object');

			if (get_class($val) == 'soapval') {
				$this->debug('serialize_val: serialize soapval object');
				$pXml = $val->serialize($use);
				$this->appendDebug($val->getDebug());
				$val->clearDebug();
			}
			else {
				if (!$name) {
					$name = get_class($val);
					$this->debug('In serialize_val, used class name ' . $name . ' as element name');
				}
				else {
					$this->debug('In serialize_val, do not override name ' . $name . ' for element name for class ' . get_class($val));
				}

				foreach (get_object_vars($val) as $k => $v) {
					$pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $pXml . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . $type_str . $atts . '>' . $pXml . '</' . $name . '>';
			}

			break;

		case is_array($val) || $type:
			$valueType = $this->isArraySimpleOrStruct($val);
			if ($valueType == 'arraySimple' || preg_match('/^ArrayOf/', $type)) {
				$this->debug('serialize_val: serialize array');
				$i = 0;
				if (is_array($val) && 0 < count($val)) {
					foreach ($val as $v) {
						if (is_object($v) && get_class($v) == 'soapval') {
							$tt_ns = $v->type_ns;
							$tt = $v->type;
						}
						else if (is_array($v)) {
							$tt = $this->isArraySimpleOrStruct($v);
						}
						else {
							$tt = gettype($v);
						}

						$array_types[$tt] = 1;
						$xml .= $this->serialize_val($v, 'item', false, false, false, false, $use);
						++$i;
					}

					if (1 < count($array_types)) {
						$array_typename = 'xsd:anyType';
					}
					else {
						if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
							if ($tt == 'integer') {
								$tt = 'int';
							}

							$array_typename = 'xsd:' . $tt;
						}
						else {
							if (isset($tt) && $tt == 'arraySimple') {
								$array_typename = 'SOAP-ENC:Array';
							}
							else {
								if (isset($tt) && $tt == 'arrayStruct') {
									$array_typename = 'unnamed_struct_use_soapval';
								}
								else {
									if ($tt_ns != '' && $tt_ns == $this->namespaces['xsd']) {
										$array_typename = 'xsd:' . $tt;
									}
									else if ($tt_ns) {
										$tt_prefix = 'ns' . rand(1000, 9999);
										$array_typename = $tt_prefix . ':' . $tt;
										$xmlns .= ' xmlns:' . $tt_prefix . '="' . $tt_ns . '"';
									}
									else {
										$array_typename = $tt;
									}
								}
							}
						}
					}

					$array_type = $i;

					if ($use == 'literal') {
						$type_str = '';
					}
					else {
						if (isset($type) && isset($type_prefix)) {
							$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
						}
						else {
							$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="' . $array_typename . ('[' . $array_type . ']"');
						}
					}
				}
				else if ($use == 'literal') {
					$type_str = '';
				}
				else {
					if (isset($type) && isset($type_prefix)) {
						$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
					}
					else {
						$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="xsd:anyType[0]"';
					}
				}

				$xml = '<' . $name . $xmlns . $type_str . $atts . '>' . $xml . ('</' . $name . '>');
			}
			else {
				$this->debug('serialize_val: serialize struct');
				if (isset($type) && isset($type_prefix)) {
					$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
				}
				else {
					$type_str = '';
				}

				if ($use == 'literal') {
					$xml .= '<' . $name . $xmlns . $atts . '>';
				}
				else {
					$xml .= '<' . $name . $xmlns . $type_str . $atts . '>';
				}

				foreach ($val as $k => $v) {
					if ($type == 'Map' && $type_ns == 'http://xml.apache.org/xml-soap') {
						$xml .= '<item>';
						$xml .= $this->serialize_val($k, 'key', false, false, false, false, $use);
						$xml .= $this->serialize_val($v, 'value', false, false, false, false, $use);
						$xml .= '</item>';
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$xml .= '</' . $name . '>';
			}

			break;

		default:
			$this->debug('serialize_val: serialize unknown');
			$xml .= 'not detected, got ' . gettype($val) . ' for ' . $val;
			break;
		}

		$this->debug('serialize_val returning ' . $xml);
		return $xml;
	}

	/**
    * serializes a message
    *
    * @param string $body the XML of the SOAP body
    * @param mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
    * @param array $namespaces optional the namespaces used in generating the body and headers
    * @param string $style optional (rpc|document)
    * @param string $use optional (encoded|literal)
    * @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
    * @return string the message
    * @access public
    */
	public function serializeEnvelope($body, $headers = false, $namespaces = array(), $style = 'rpc', $use = 'encoded', $encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/')
	{
		$this->debug('In serializeEnvelope length=' . strlen($body) . ' body (max 1000 characters)=' . substr($body, 0, 1000) . (' style=' . $style . ' use=' . $use . ' encodingStyle=' . $encodingStyle));
		$this->debug('headers:');
		$this->appendDebug($this->varDump($headers));
		$this->debug('namespaces:');
		$this->appendDebug($this->varDump($namespaces));
		$ns_string = '';

		foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
			$ns_string .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if ($encodingStyle) {
			$ns_string = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"' . $ns_string;
		}

		if ($headers) {
			if (is_array($headers)) {
				$xml = '';

				foreach ($headers as $k => $v) {
					if (is_object($v) && get_class($v) == 'soapval') {
						$xml .= $this->serialize_val($v, false, false, false, false, false, $use);
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$headers = $xml;
				$this->debug('In serializeEnvelope, serialized array of headers to ' . $headers);
			}

			$headers = '<SOAP-ENV:Header>' . $headers . '</SOAP-ENV:Header>';
		}

		return '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?' . '>' . '<SOAP-ENV:Envelope' . $ns_string . '>' . $headers . '<SOAP-ENV:Body>' . $body . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
	}

	/**
	 * formats a string to be inserted into an HTML stream
	 *
	 * @param string $str The string to format
	 * @return string The formatted string
	 * @access public
	 * @deprecated
	 */
	public function formatDump($str)
	{
		$str = htmlspecialchars($str);
		return nl2br($str);
	}

	/**
	* contracts (changes namespace to prefix) a qualified name
	*
	* @param    string $qname qname
	* @return	string contracted qname
	* @access   private
	*/
	public function contractQname($qname)
	{
		if (strrpos($qname, ':')) {
			$name = substr($qname, strrpos($qname, ':') + 1);
			$ns = substr($qname, 0, strrpos($qname, ':'));
			$p = $this->getPrefixFromNamespace($ns);

			if ($p) {
				return $p . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
	* expands (changes prefix to namespace) a qualified name
	*
	* @param    string $qname qname
	* @return	string expanded qname
	* @access   private
	*/
	public function expandQname($qname)
	{
		if (strpos($qname, ':') && !preg_match('/^http:\\/\\//', $qname)) {
			$name = substr(strstr($qname, ':'), 1);
			$prefix = substr($qname, 0, strpos($qname, ':'));

			if (isset($this->namespaces[$prefix])) {
				return $this->namespaces[$prefix] . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
    * returns the local part of a prefixed string
    * returns the original string, if not prefixed
    *
    * @param string $str The prefixed string
    * @return string The local part
    * @access public
    */
	public function getLocalPart($str)
	{
		if ($sstr = strrchr($str, ':')) {
			return substr($sstr, 1);
		}

		return $str;
	}

	/**
    * returns the prefix part of a prefixed string
    * returns false, if not prefixed
    *
    * @param string $str The prefixed string
    * @return mixed The prefix or false if there is no prefix
    * @access public
    */
	public function getPrefix($str)
	{
		if ($pos = strrpos($str, ':')) {
			return substr($str, 0, $pos);
		}

		return false;
	}

	/**
    * pass it a prefix, it returns a namespace
    *
    * @param string $prefix The prefix
    * @return mixed The namespace, false if no namespace has the specified prefix
    * @access public
    */
	public function getNamespaceFromPrefix($prefix)
	{
		if (isset($this->namespaces[$prefix])) {
			return $this->namespaces[$prefix];
		}

		return false;
	}

	/**
    * returns the prefix for a given namespace (or prefix)
    * or false if no prefixes registered for the given namespace
    *
    * @param string $ns The namespace
    * @return mixed The prefix, false if the namespace has no prefixes
    * @access public
    */
	public function getPrefixFromNamespace($ns)
	{
		foreach ($this->namespaces as $p => $n) {
			if ($ns == $n || $ns == $p) {
				$this->usedNamespaces[$p] = $n;
				return $p;
			}
		}

		return false;
	}

	/**
    * returns the time in ODBC canonical form with microseconds
    *
    * @return string The time in ODBC canonical form with microseconds
    * @access public
    */
	public function getmicrotime()
	{
		if (function_exists('gettimeofday')) {
			$tod = gettimeofday();
			$sec = $tod['sec'];
			$usec = $tod['usec'];
		}
		else {
			$sec = time();
			$usec = 0;
		}

		return strftime('%Y-%m-%d %H:%M:%S', $sec) . '.' . sprintf('%06d', $usec);
	}

	/**
	 * Returns a string with the output of var_dump
	 *
	 * @param mixed $data The variable to var_dump
	 * @return string The output of var_dump
	 * @access public
	 */
	public function varDump($data)
	{
		ob_start();
		var_dump($data);
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	/**
	* represents the object as a string
	*
	* @return	string
	* @access   public
	*/
	public function __toString()
	{
		return $this->varDump($this);
	}
}

class soap_parser extends nusoap_parser
{
	public $xml = '';
	public $xml_encoding = '';
	public $method = '';
	public $root_struct = '';
	public $root_struct_name = '';
	public $root_struct_namespace = '';
	public $root_header = '';
	public $document = '';
	public $status = '';
	public $position = 0;
	public $depth = 0;
	public $default_namespace = '';
	public $namespaces = array();
	public $message = array();
	public $parent = '';
	public $fault = false;
	public $fault_code = '';
	public $fault_str = '';
	public $fault_detail = '';
	public $depth_array = array();
	public $debug_flag = true;
	public $soapresponse;
	public $soapheader;
	public $responseHeaders = '';
	public $body_position = 0;
	public $ids = array();
	public $multirefs = array();
	public $decode_utf8 = true;
	/**
	 * Identification for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $title = 'NuSOAP';
	/**
	 * Version for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $version = '0.9.5';
	/**
	 * CVS revision for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $revision = '$Revision: 1.123 $';
	/**
     * Current error string (manipulated by getError/setError)
	 *
	 * @var string
	 * @access private
	 */
	public $error_str = '';
	/**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
	 *
	 * @var string
	 * @access private
	 */
	public $debug_str = '';
	/**
	 * toggles automatic encoding of special characters as entities
	 * (should always be true, I think)
	 *
	 * @var boolean
	 * @access private
	 */
	public $charencoding = true;
	/**
	 * the debug level for this instance
	 *
	 * @var	integer
	 * @access private
	 */
	public $debugLevel;
	/**
	* set schema version
	*
	* @var      string
	* @access   public
	*/
	public $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';
	/**
	* charset encoding for outgoing messages
	*
	* @var      string
	* @access   public
	*/
	public $soap_defencoding = 'ISO-8859-1';
	/**
	* namespaces used in the current context, e.g. during serialization
	*
	* @var      array
	* @access   private
	*/
	public $usedNamespaces = array();
	/**
	* XML Schema types in an array of uri => (array of xml type => php type)
	* is this legacy yet?
	* no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
	* @var      array
	* @access   public
	*/
	public $typemap = array(
		'http://www.w3.org/2001/XMLSchema'          => array('string' => 'string', 'boolean' => 'boolean', 'float' => 'double', 'double' => 'double', 'decimal' => 'double', 'duration' => '', 'dateTime' => 'string', 'time' => 'string', 'date' => 'string', 'gYearMonth' => '', 'gYear' => '', 'gMonthDay' => '', 'gDay' => '', 'gMonth' => '', 'hexBinary' => 'string', 'base64Binary' => 'string', 'anyType' => 'string', 'anySimpleType' => 'string', 'normalizedString' => 'string', 'token' => 'string', 'language' => '', 'NMTOKEN' => '', 'NMTOKENS' => '', 'Name' => '', 'NCName' => '', 'ID' => '', 'IDREF' => '', 'IDREFS' => '', 'ENTITY' => '', 'ENTITIES' => '', 'integer' => 'integer', 'nonPositiveInteger' => 'integer', 'negativeInteger' => 'integer', 'long' => 'integer', 'int' => 'integer', 'short' => 'integer', 'byte' => 'integer', 'nonNegativeInteger' => 'integer', 'unsignedLong' => '', 'unsignedInt' => '', 'unsignedShort' => '', 'unsignedByte' => '', 'positiveInteger' => ''),
		'http://www.w3.org/2000/10/XMLSchema'       => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://www.w3.org/1999/XMLSchema'          => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://soapinterop.org/xsd'                => array('SOAPStruct' => 'struct'),
		'http://schemas.xmlsoap.org/soap/encoding/' => array('base64' => 'string', 'array' => 'array', 'Array' => 'array'),
		'http://xml.apache.org/xml-soap'            => array('Map')
		);
	/**
	* XML entities to convert
	*
	* @var      array
	* @access   public
	* @deprecated
	* @see	expandEntities
	*/
	public $xmlEntities = array('quot' => '"', 'amp' => '&', 'lt' => '<', 'gt' => '>', 'apos' => '\'');

	/**
	* constructor that actually does the parsing
	*
	* @param    string $xml SOAP message
	* @param    string $encoding character encoding scheme of message
	* @param    string $method method for which XML is parsed (unused?)
	* @param    string $decode_utf8 whether to decode UTF-8 to ISO-8859-1
	* @access   public
	*/
	public function nusoap_parser($xml, $encoding = 'UTF-8', $method = '', $decode_utf8 = true)
	{
		parent::nusoap_base();
		$this->xml = $xml;
		$this->xml_encoding = $encoding;
		$this->method = $method;
		$this->decode_utf8 = $decode_utf8;

		if (!empty($xml)) {
			$pos_xml = strpos($xml, '<?xml');

			if ($pos_xml !== false) {
				$xml_decl = substr($xml, $pos_xml, strpos($xml, '?>', $pos_xml + 2) - $pos_xml + 1);

				if (preg_match('/encoding=["\']([^"\']*)["\']/', $xml_decl, $res)) {
					$xml_encoding = $res[1];

					if (strtoupper($xml_encoding) != $encoding) {
						$err = 'Charset from HTTP Content-Type \'' . $encoding . '\' does not match encoding from XML declaration \'' . $xml_encoding . '\'';
						$this->debug($err);
						if ($encoding != 'ISO-8859-1' || strtoupper($xml_encoding) != 'UTF-8') {
							$this->setError($err);
							return NULL;
						}
					}
					else {
						$this->debug('Charset from HTTP Content-Type matches encoding from XML declaration');
					}
				}
				else {
					$this->debug('No encoding specified in XML declaration');
				}
			}
			else {
				$this->debug('No XML declaration');
			}

			$this->debug('Entering nusoap_parser(), length=' . strlen($xml) . ', encoding=' . $encoding);
			$this->parser = xml_parser_create($this->xml_encoding);
			xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);
			xml_parser_set_option($this->parser, XML_OPTION_TARGET_ENCODING, $this->xml_encoding);
			xml_set_object($this->parser, $this);
			xml_set_element_handler($this->parser, 'start_element', 'end_element');
			xml_set_character_data_handler($this->parser, 'character_data');

			if (!xml_parse($this->parser, $xml, true)) {
				$err = sprintf('XML error parsing SOAP payload on line %d: %s', xml_get_current_line_number($this->parser), xml_error_string(xml_get_error_code($this->parser)));
				$this->debug($err);
				$this->debug("XML payload:\n" . $xml);
				$this->setError($err);
			}
			else {
				$this->debug('in nusoap_parser ctor, message:');
				$this->appendDebug($this->varDump($this->message));
				$this->debug('parsed successfully, found root struct: ' . $this->root_struct . ' of name ' . $this->root_struct_name);
				$this->soapresponse = $this->message[$this->root_struct]['result'];
				if ($this->root_header != '' && isset($this->message[$this->root_header]['result'])) {
					$this->soapheader = $this->message[$this->root_header]['result'];
				}

				if (0 < sizeof($this->multirefs)) {
					foreach ($this->multirefs as $id => $hrefs) {
						$this->debug('resolving multirefs for id: ' . $id);
						$idVal = $this->buildVal($this->ids[$id]);
						if (is_array($idVal) && isset($idVal['!id'])) {
							unset($idVal['!id']);
						}

						foreach ($hrefs as $refPos => $ref) {
							$this->debug('resolving href at pos ' . $refPos);
							$this->multirefs[$id][$refPos] = $idVal;
						}
					}
				}
			}

			xml_parser_free($this->parser);
			return NULL;
		}

		$this->debug('xml was empty, didn\'t parse!');
		$this->setError('xml was empty, didn\'t parse!');
	}

	/**
	* start-element handler
	*
	* @param    resource $parser XML parser object
	* @param    string $name element name
	* @param    array $attrs associative array of attributes
	* @access   private
	*/
	public function start_element($parser, $name, $attrs)
	{
		$pos = $this->position++;
		$this->message[$pos] = array('pos' => $pos, 'children' => '', 'cdata' => '');
		$this->message[$pos]['depth'] = $this->depth++;

		if ($pos != 0) {
			$this->message[$this->parent]['children'] .= '|' . $pos;
		}

		$this->message[$pos]['parent'] = $this->parent;
		$this->parent = $pos;
		$this->depth_array[$this->depth] = $pos;

		if (strpos($name, ':')) {
			$prefix = substr($name, 0, strpos($name, ':'));
			$name = substr(strstr($name, ':'), 1);
		}

		if ($name == 'Envelope' && $this->status == '') {
			$this->status = 'envelope';
		}
		else {
			if ($name == 'Header' && $this->status == 'envelope') {
				$this->root_header = $pos;
				$this->status = 'header';
			}
			else {
				if ($name == 'Body' && $this->status == 'envelope') {
					$this->status = 'body';
					$this->body_position = $pos;
				}
				else {
					if ($this->status == 'body' && $pos == $this->body_position + 1) {
						$this->status = 'method';
						$this->root_struct_name = $name;
						$this->root_struct = $pos;
						$this->message[$pos]['type'] = 'struct';
						$this->debug('found root struct ' . $this->root_struct_name . ', pos ' . $this->root_struct);
					}
				}
			}
		}

		$this->message[$pos]['status'] = $this->status;
		$this->message[$pos]['name'] = htmlspecialchars($name);
		$this->message[$pos]['attrs'] = $attrs;
		$attstr = '';

		foreach ($attrs as $key => $value) {
			$key_prefix = $this->getPrefix($key);
			$key_localpart = $this->getLocalPart($key);

			if ($key_prefix == 'xmlns') {
				if (preg_match('/^http:\\/\\/www.w3.org\\/[0-9]{4}\\/XMLSchema$/', $value)) {
					$this->XMLSchemaVersion = $value;
					$this->namespaces['xsd'] = $this->XMLSchemaVersion;
					$this->namespaces['xsi'] = $this->XMLSchemaVersion . '-instance';
				}

				$this->namespaces[$key_localpart] = $value;

				if ($name == $this->root_struct_name) {
					$this->methodNamespace = $value;
				}
			}
			else if ($key_localpart == 'type') {
				if (isset($this->message[$pos]['type']) && $this->message[$pos]['type'] == 'array') {
				}
				else {
					$value_prefix = $this->getPrefix($value);
					$value_localpart = $this->getLocalPart($value);
					$this->message[$pos]['type'] = $value_localpart;
					$this->message[$pos]['typePrefix'] = $value_prefix;

					if (isset($this->namespaces[$value_prefix])) {
						$this->message[$pos]['type_namespace'] = $this->namespaces[$value_prefix];
					}
					else {
						if (isset($attrs['xmlns:' . $value_prefix])) {
							$this->message[$pos]['type_namespace'] = $attrs['xmlns:' . $value_prefix];
						}
					}
				}
			}
			else if ($key_localpart == 'arrayType') {
				$this->message[$pos]['type'] = 'array';
				$expr = '/([A-Za-z0-9_]+):([A-Za-z]+[A-Za-z0-9_]+)\\[([0-9]+),?([0-9]*)\\]/';

				if (preg_match($expr, $value, $regs)) {
					$this->message[$pos]['typePrefix'] = $regs[1];
					$this->message[$pos]['arrayTypePrefix'] = $regs[1];

					if (isset($this->namespaces[$regs[1]])) {
						$this->message[$pos]['arrayTypeNamespace'] = $this->namespaces[$regs[1]];
					}
					else {
						if (isset($attrs['xmlns:' . $regs[1]])) {
							$this->message[$pos]['arrayTypeNamespace'] = $attrs['xmlns:' . $regs[1]];
						}
					}

					$this->message[$pos]['arrayType'] = $regs[2];
					$this->message[$pos]['arraySize'] = $regs[3];
					$this->message[$pos]['arrayCols'] = $regs[4];
				}
			}
			else if ($key_localpart == 'nil') {
				$this->message[$pos]['nil'] = $value == 'true' || $value == '1';
			}
			else {
				if ($key != 'href' && $key != 'xmlns' && $key_localpart != 'encodingStyle' && $key_localpart != 'root') {
					$this->message[$pos]['xattrs']['!' . $key] = $value;
				}
			}

			if ($key == 'xmlns') {
				$this->default_namespace = $value;
			}

			if ($key == 'id') {
				$this->ids[$value] = $pos;
			}

			if ($key_localpart == 'root' && $value == 1) {
				$this->status = 'method';
				$this->root_struct_name = $name;
				$this->root_struct = $pos;
				$this->debug('found root struct ' . $this->root_struct_name . ', pos ' . $pos);
			}

			$attstr .= ' ' . $key . '="' . $value . '"';
		}

		if (isset($prefix)) {
			$this->message[$pos]['namespace'] = $this->namespaces[$prefix];
			$this->default_namespace = $this->namespaces[$prefix];
		}
		else {
			$this->message[$pos]['namespace'] = $this->default_namespace;
		}

		if ($this->status == 'header') {
			if ($this->root_header != $pos) {
				$this->responseHeaders .= '<' . (isset($prefix) ? $prefix . ':' : '') . ($name . $attstr . '>');
				return NULL;
			}
		}
		else {
			if ($this->root_struct_name != '') {
				$this->document .= '<' . (isset($prefix) ? $prefix . ':' : '') . ($name . $attstr . '>');
			}
		}
	}

	/**
	* end-element handler
	*
	* @param    resource $parser XML parser object
	* @param    string $name element name
	* @access   private
	*/
	public function end_element($parser, $name)
	{
		$pos = $this->depth_array[$this->depth--];

		if (strpos($name, ':')) {
			$prefix = substr($name, 0, strpos($name, ':'));
			$name = substr(strstr($name, ':'), 1);
		}

		if (isset($this->body_position) && $this->body_position < $pos) {
			if (isset($this->message[$pos]['attrs']['href'])) {
				$id = substr($this->message[$pos]['attrs']['href'], 1);
				$this->multirefs[$id][$pos] = 'placeholder';
				$this->message[$pos]['result'] = &$this->multirefs[$id][$pos];
			}
			else if ($this->message[$pos]['children'] != '') {
				if (!isset($this->message[$pos]['result'])) {
					$this->message[$pos]['result'] = $this->buildVal($pos);
				}
			}
			else if (isset($this->message[$pos]['xattrs'])) {
				if (isset($this->message[$pos]['nil']) && $this->message[$pos]['nil']) {
					$this->message[$pos]['xattrs']['!'] = NULL;
				}
				else {
					if (isset($this->message[$pos]['cdata']) && trim($this->message[$pos]['cdata']) != '') {
						if (isset($this->message[$pos]['type'])) {
							$this->message[$pos]['xattrs']['!'] = $this->decodeSimple($this->message[$pos]['cdata'], $this->message[$pos]['type'], isset($this->message[$pos]['type_namespace']) ? $this->message[$pos]['type_namespace'] : '');
						}
						else {
							$parent = $this->message[$pos]['parent'];
							if (isset($this->message[$parent]['type']) && $this->message[$parent]['type'] == 'array' && isset($this->message[$parent]['arrayType'])) {
								$this->message[$pos]['xattrs']['!'] = $this->decodeSimple($this->message[$pos]['cdata'], $this->message[$parent]['arrayType'], isset($this->message[$parent]['arrayTypeNamespace']) ? $this->message[$parent]['arrayTypeNamespace'] : '');
							}
							else {
								$this->message[$pos]['xattrs']['!'] = $this->message[$pos]['cdata'];
							}
						}
					}
				}

				$this->message[$pos]['result'] = $this->message[$pos]['xattrs'];
			}
			else {
				if (isset($this->message[$pos]['nil']) && $this->message[$pos]['nil']) {
					$this->message[$pos]['xattrs']['!'] = NULL;
				}
				else if (isset($this->message[$pos]['type'])) {
					$this->message[$pos]['result'] = $this->decodeSimple($this->message[$pos]['cdata'], $this->message[$pos]['type'], isset($this->message[$pos]['type_namespace']) ? $this->message[$pos]['type_namespace'] : '');
				}
				else {
					$parent = $this->message[$pos]['parent'];
					if (isset($this->message[$parent]['type']) && $this->message[$parent]['type'] == 'array' && isset($this->message[$parent]['arrayType'])) {
						$this->message[$pos]['result'] = $this->decodeSimple($this->message[$pos]['cdata'], $this->message[$parent]['arrayType'], isset($this->message[$parent]['arrayTypeNamespace']) ? $this->message[$parent]['arrayTypeNamespace'] : '');
					}
					else {
						$this->message[$pos]['result'] = $this->message[$pos]['cdata'];
					}
				}
			}
		}

		if ($this->status == 'header') {
			if ($this->root_header != $pos) {
				$this->responseHeaders .= '</' . (isset($prefix) ? $prefix . ':' : '') . ($name . '>');
			}
		}
		else {
			if ($this->root_struct <= $pos) {
				$this->document .= '</' . (isset($prefix) ? $prefix . ':' : '') . ($name . '>');
			}
		}

		if ($pos == $this->root_struct) {
			$this->status = 'body';
			$this->root_struct_namespace = $this->message[$pos]['namespace'];
		}
		else if ($pos == $this->root_header) {
			$this->status = 'envelope';
		}
		else {
			if ($name == 'Body' && $this->status == 'body') {
				$this->status = 'envelope';
			}
			else {
				if ($name == 'Header' && $this->status == 'header') {
					$this->status = 'envelope';
				}
				else {
					if ($name == 'Envelope' && $this->status == 'envelope') {
						$this->status = '';
					}
				}
			}
		}

		$this->parent = $this->message[$pos]['parent'];
	}

	/**
	* element content handler
	*
	* @param    resource $parser XML parser object
	* @param    string $data element content
	* @access   private
	*/
	public function character_data($parser, $data)
	{
		$pos = $this->depth_array[$this->depth];

		if ($this->xml_encoding == 'UTF-8') {
			if ($this->decode_utf8) {
				$data = utf8_decode($data);
			}
		}

		$this->message[$pos]['cdata'] .= $data;

		if ($this->status == 'header') {
			$this->responseHeaders .= $data;
			return NULL;
		}

		$this->document .= $data;
	}

	/**
	* get the parsed message (SOAP Body)
	*
	* @return	mixed
	* @access   public
	* @deprecated	use get_soapbody instead
	*/
	public function get_response()
	{
		return $this->soapresponse;
	}

	/**
	* get the parsed SOAP Body (NULL if there was none)
	*
	* @return	mixed
	* @access   public
	*/
	public function get_soapbody()
	{
		return $this->soapresponse;
	}

	/**
	* get the parsed SOAP Header (NULL if there was none)
	*
	* @return	mixed
	* @access   public
	*/
	public function get_soapheader()
	{
		return $this->soapheader;
	}

	/**
	* get the unparsed SOAP Header
	*
	* @return	string XML or empty if no Header
	* @access   public
	*/
	public function getHeaders()
	{
		return $this->responseHeaders;
	}

	/**
	* decodes simple types into PHP variables
	*
	* @param    string $value value to decode
	* @param    string $type XML type to decode
	* @param    string $typens XML type namespace to decode
	* @return	mixed PHP value
	* @access   private
	*/
	public function decodeSimple($value, $type, $typens)
	{
		if (!isset($type) || $type == 'string' || $type == 'long' || $type == 'unsignedLong') {
			return (string) $value;
		}

		if ($type == 'int' || $type == 'integer' || $type == 'short' || $type == 'byte') {
			return (int) $value;
		}

		if ($type == 'float' || $type == 'double' || $type == 'decimal') {
			return (double) $value;
		}

		if ($type == 'boolean') {
			if (strtolower($value) == 'false' || strtolower($value) == 'f') {
				return false;
			}

			return (bool) $value;
		}

		if ($type == 'base64' || $type == 'base64Binary') {
			$this->debug('Decode base64 value');
			return base64_decode($value);
		}

		if ($type == 'nonPositiveInteger' || $type == 'negativeInteger' || $type == 'nonNegativeInteger' || $type == 'positiveInteger' || $type == 'unsignedInt' || $type == 'unsignedShort' || $type == 'unsignedByte') {
			return (int) $value;
		}

		if ($type == 'array') {
			return array();
		}

		return (string) $value;
	}

	/**
	* builds response structures for compound values (arrays/structs)
	* and scalars
	*
	* @param    integer $pos position in node tree
	* @return	mixed	PHP value
	* @access   private
	*/
	public function buildVal($pos)
	{
		if (!isset($this->message[$pos]['type'])) {
			$this->message[$pos]['type'] = '';
		}

		$this->debug('in buildVal() for ' . $this->message[$pos]['name'] . ('(pos ' . $pos . ') of type ') . $this->message[$pos]['type']);

		if ($this->message[$pos]['children'] != '') {
			$this->debug('in buildVal, there are children');
			$children = explode('|', $this->message[$pos]['children']);
			array_shift($children);
			if (isset($this->message[$pos]['arrayCols']) && $this->message[$pos]['arrayCols'] != '') {
				$r = 0;
				$c = 0;

				foreach ($children as $child_pos) {
					$this->debug('in buildVal, got an MD array element: ' . $r . ', ' . $c);
					$params[$r][] = $this->message[$child_pos]['result'];
					++$c;

					if ($c == $this->message[$pos]['arrayCols']) {
						$c = 0;
						++$r;
					}
				}
			}
			else {
				if ($this->message[$pos]['type'] == 'array' || $this->message[$pos]['type'] == 'Array') {
					$this->debug('in buildVal, adding array ' . $this->message[$pos]['name']);

					foreach ($children as $child_pos) {
						$params[] = &$this->message[$child_pos]['result'];
					}
				}
				else {
					if ($this->message[$pos]['type'] == 'Map' && $this->message[$pos]['type_namespace'] == 'http://xml.apache.org/xml-soap') {
						$this->debug('in buildVal, Java Map ' . $this->message[$pos]['name']);

						foreach ($children as $child_pos) {
							$kv = explode('|', $this->message[$child_pos]['children']);
							$params[$this->message[$kv[1]]['result']] = &$this->message[$kv[2]]['result'];
						}
					}
					else {
						$this->debug('in buildVal, adding Java Vector or generic compound type ' . $this->message[$pos]['name']);
						if ($this->message[$pos]['type'] == 'Vector' && $this->message[$pos]['type_namespace'] == 'http://xml.apache.org/xml-soap') {
							$notstruct = 1;
						}
						else {
							$notstruct = 0;
						}

						foreach ($children as $child_pos) {
							if ($notstruct) {
								$params[] = &$this->message[$child_pos]['result'];
							}
							else if (isset($params[$this->message[$child_pos]['name']])) {
								if (!is_array($params[$this->message[$child_pos]['name']]) || !isset($params[$this->message[$child_pos]['name']][0])) {
									$params[$this->message[$child_pos]['name']] = array($params[$this->message[$child_pos]['name']]);
								}

								$params[$this->message[$child_pos]['name']][] = &$this->message[$child_pos]['result'];
							}
							else {
								$params[$this->message[$child_pos]['name']] = &$this->message[$child_pos]['result'];
							}
						}
					}
				}
			}

			if (isset($this->message[$pos]['xattrs'])) {
				$this->debug('in buildVal, handling attributes');

				foreach ($this->message[$pos]['xattrs'] as $n => $v) {
					$params[$n] = $v;
				}
			}

			if (isset($this->message[$pos]['cdata']) && trim($this->message[$pos]['cdata']) != '') {
				$this->debug('in buildVal, handling simpleContent');

				if (isset($this->message[$pos]['type'])) {
					$params['!'] = $this->decodeSimple($this->message[$pos]['cdata'], $this->message[$pos]['type'], isset($this->message[$pos]['type_namespace']) ? $this->message[$pos]['type_namespace'] : '');
				}
				else {
					$parent = $this->message[$pos]['parent'];
					if (isset($this->message[$parent]['type']) && $this->message[$parent]['type'] == 'array' && isset($this->message[$parent]['arrayType'])) {
						$params['!'] = $this->decodeSimple($this->message[$pos]['cdata'], $this->message[$parent]['arrayType'], isset($this->message[$parent]['arrayTypeNamespace']) ? $this->message[$parent]['arrayTypeNamespace'] : '');
					}
					else {
						$params['!'] = $this->message[$pos]['cdata'];
					}
				}
			}

			$ret = is_array($params) ? $params : array();
			$this->debug('in buildVal, return:');
			$this->appendDebug($this->varDump($ret));
			return $ret;
		}

		$this->debug('in buildVal, no children, building scalar');
		$cdata = isset($this->message[$pos]['cdata']) ? $this->message[$pos]['cdata'] : '';

		if (isset($this->message[$pos]['type'])) {
			$ret = $this->decodeSimple($cdata, $this->message[$pos]['type'], isset($this->message[$pos]['type_namespace']) ? $this->message[$pos]['type_namespace'] : '');
			$this->debug('in buildVal, return: ' . $ret);
			return $ret;
		}

		$parent = $this->message[$pos]['parent'];
		if (isset($this->message[$parent]['type']) && $this->message[$parent]['type'] == 'array' && isset($this->message[$parent]['arrayType'])) {
			$ret = $this->decodeSimple($cdata, $this->message[$parent]['arrayType'], isset($this->message[$parent]['arrayTypeNamespace']) ? $this->message[$parent]['arrayTypeNamespace'] : '');
			$this->debug('in buildVal, return: ' . $ret);
			return $ret;
		}

		$ret = $this->message[$pos]['cdata'];
		$this->debug('in buildVal, return: ' . $ret);
		return $ret;
	}

	/**
	* constructor
	*
	* @access	public
	*/
	public function nusoap_base()
	{
		$this->debugLevel = $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* gets the global debug level, which applies to future instances
	*
	* @return	integer	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getGlobalDebugLevel()
	{
		return $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* sets the global debug level, which applies to future instances
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setGlobalDebugLevel($level)
	{
		$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = $level;
	}

	/**
	* gets the debug level for this instance
	*
	* @return	int	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}

	/**
	* sets the debug level for this instance
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}

	/**
	* adds debug data to the instance debug string with formatting
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function debug($string)
	{
		if (0 < $this->debugLevel) {
			$this->appendDebug($this->getmicrotime() . ' ' . get_class($this) . (': ' . $string . "\n"));
		}
	}

	/**
	* adds debug data to the instance debug string without formatting
	*
	* @param    string $string debug data
	* @access   public
	*/
	public function appendDebug($string)
	{
		if (0 < $this->debugLevel) {
			$this->debug_str .= $string;
		}
	}

	/**
	* clears the current debug data for this instance
	*
	* @access   public
	*/
	public function clearDebug()
	{
		$this->debug_str = '';
	}

	/**
	* gets the current debug data for this instance
	*
	* @return   debug data
	* @access   public
	*/
	public function& getDebug()
	{
		return $this->debug_str;
	}

	/**
	* gets the current debug data for this instance as an XML comment
	* this may change the contents of the debug data
	*
	* @return   debug data as an XML comment
	* @access   public
	*/
	public function& getDebugAsXMLComment()
	{
		while (strpos($this->debug_str, '--')) {
			$this->debug_str = str_replace('--', '- -', $this->debug_str);
		}

		$ret = "<!--\n" . $this->debug_str . "\n-->";
		return $ret;
	}

	/**
	* expands entities, e.g. changes '<' to '&lt;'.
	*
	* @param	string	$val	The string in which to expand entities.
	* @access	private
	*/
	public function expandEntities($val)
	{
		if ($this->charencoding) {
			$val = str_replace('&', '&amp;', $val);
			$val = str_replace('\'', '&apos;', $val);
			$val = str_replace('"', '&quot;', $val);
			$val = str_replace('<', '&lt;', $val);
			$val = str_replace('>', '&gt;', $val);
		}

		return $val;
	}

	/**
	* returns error string if present
	*
	* @return   mixed error string or false
	* @access   public
	*/
	public function getError()
	{
		if ($this->error_str != '') {
			return $this->error_str;
		}

		return false;
	}

	/**
	* sets error string
	*
	* @return   boolean $string error string
	* @access   private
	*/
	public function setError($str)
	{
		$this->error_str = $str;
	}

	/**
	* detect if array is a simple array or a struct (associative array)
	*
	* @param	mixed	$val	The PHP array
	* @return	string	(arraySimple|arrayStruct)
	* @access	private
	*/
	public function isArraySimpleOrStruct($val)
	{
		$keyList = array_keys($val);

		foreach ($keyList as $keyListValue) {
			if (!is_int($keyListValue)) {
				return 'arrayStruct';
			}
		}

		return 'arraySimple';
	}

	/**
	* serializes PHP values in accordance w/ section 5. Type information is
	* not serialized if $use == 'literal'.
	*
	* @param	mixed	$val	The value to serialize
	* @param	string	$name	The name (local part) of the XML element
	* @param	string	$type	The XML schema type (local part) for the element
	* @param	string	$name_ns	The namespace for the name of the XML element
	* @param	string	$type_ns	The namespace for the type of the element
	* @param	array	$attributes	The attributes to serialize as name=>value pairs
	* @param	string	$use	The WSDL "use" (encoded|literal)
	* @param	boolean	$soapval	Whether this is called from soapval.
	* @return	string	The serialized element, possibly with child elements
    * @access	public
	*/
	public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = 'encoded', $soapval = false)
	{
		$this->debug('in serialize_val: name=' . $name . ', type=' . $type . ', name_ns=' . $name_ns . ', type_ns=' . $type_ns . ', use=' . $use . ', soapval=' . $soapval);
		$this->appendDebug('value=' . $this->varDump($val));
		$this->appendDebug('attributes=' . $this->varDump($attributes));
		if (is_object($val) && get_class($val) == 'soapval' && !$soapval) {
			$this->debug('serialize_val: serialize soapval');
			$xml = $val->serialize($use);
			$this->appendDebug($val->getDebug());
			$val->clearDebug();
			$this->debug('serialize_val of soapval returning ' . $xml);
			return $xml;
		}

		if (is_numeric($name)) {
			$name = '__numeric_' . $name;
		}
		else {
			if (!$name) {
				$name = 'noname';
			}
		}

		$xmlns = '';

		if ($name_ns) {
			$prefix = 'nu' . rand(1000, 9999);
			$name = $prefix . ':' . $name;
			$xmlns .= ' xmlns:' . $prefix . '="' . $name_ns . '"';
		}

		if ($type_ns != '' && $type_ns == $this->namespaces['xsd']) {
			$type_prefix = 'xsd';
		}
		else {
			if ($type_ns) {
				$type_prefix = 'ns' . rand(1000, 9999);
				$xmlns .= ' xmlns:' . $type_prefix . '="' . $type_ns . '"';
			}
		}

		$atts = '';

		if ($attributes) {
			foreach ($attributes as $k => $v) {
				$atts .= ' ' . $k . '="' . $this->expandEntities($v) . '"';
			}
		}

		if (is_null($val)) {
			$this->debug('serialize_val: serialize null');

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '/>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			$xml = '<' . $name . $xmlns . $type_str . $atts . ' xsi:nil="true"/>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		if ($type != '' && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
			$this->debug('serialize_val: serialize xsd built-in primitive type');

			if (is_bool($val)) {
				if ($type == 'boolean') {
					$val = $val ? 'true' : 'false';
				}
				else {
					if (!$val) {
						$val = 0;
					}
				}
			}
			else {
				if (is_string($val)) {
					$val = $this->expandEntities($val);
				}
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			$xml = '<' . $name . $xmlns . ' xsi:type="xsd:' . $type . '"' . $atts . '>' . $val . '</' . $name . '>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		$xml = '';
		switch (true) {
		case is_bool($val) || $type == 'boolean':
			$this->debug('serialize_val: serialize boolean');

			if ($type == 'boolean') {
				$val = $val ? 'true' : 'false';
			}
			else {
				if (!$val) {
					$val = 0;
				}
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:boolean"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_int($val) || is_long($val) || $type == 'int':
			$this->debug('serialize_val: serialize int');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:int"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_float($val) || is_double($val) || $type == 'float':
			$this->debug('serialize_val: serialize float');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:float"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_string($val) || $type == 'string':
			$this->debug('serialize_val: serialize string');
			$val = $this->expandEntities($val);

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:string"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_object($val):
			$this->debug('serialize_val: serialize object');

			if (get_class($val) == 'soapval') {
				$this->debug('serialize_val: serialize soapval object');
				$pXml = $val->serialize($use);
				$this->appendDebug($val->getDebug());
				$val->clearDebug();
			}
			else {
				if (!$name) {
					$name = get_class($val);
					$this->debug('In serialize_val, used class name ' . $name . ' as element name');
				}
				else {
					$this->debug('In serialize_val, do not override name ' . $name . ' for element name for class ' . get_class($val));
				}

				foreach (get_object_vars($val) as $k => $v) {
					$pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $pXml . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . $type_str . $atts . '>' . $pXml . '</' . $name . '>';
			}

			break;

		case is_array($val) || $type:
			$valueType = $this->isArraySimpleOrStruct($val);
			if ($valueType == 'arraySimple' || preg_match('/^ArrayOf/', $type)) {
				$this->debug('serialize_val: serialize array');
				$i = 0;
				if (is_array($val) && 0 < count($val)) {
					foreach ($val as $v) {
						if (is_object($v) && get_class($v) == 'soapval') {
							$tt_ns = $v->type_ns;
							$tt = $v->type;
						}
						else if (is_array($v)) {
							$tt = $this->isArraySimpleOrStruct($v);
						}
						else {
							$tt = gettype($v);
						}

						$array_types[$tt] = 1;
						$xml .= $this->serialize_val($v, 'item', false, false, false, false, $use);
						++$i;
					}

					if (1 < count($array_types)) {
						$array_typename = 'xsd:anyType';
					}
					else {
						if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
							if ($tt == 'integer') {
								$tt = 'int';
							}

							$array_typename = 'xsd:' . $tt;
						}
						else {
							if (isset($tt) && $tt == 'arraySimple') {
								$array_typename = 'SOAP-ENC:Array';
							}
							else {
								if (isset($tt) && $tt == 'arrayStruct') {
									$array_typename = 'unnamed_struct_use_soapval';
								}
								else {
									if ($tt_ns != '' && $tt_ns == $this->namespaces['xsd']) {
										$array_typename = 'xsd:' . $tt;
									}
									else if ($tt_ns) {
										$tt_prefix = 'ns' . rand(1000, 9999);
										$array_typename = $tt_prefix . ':' . $tt;
										$xmlns .= ' xmlns:' . $tt_prefix . '="' . $tt_ns . '"';
									}
									else {
										$array_typename = $tt;
									}
								}
							}
						}
					}

					$array_type = $i;

					if ($use == 'literal') {
						$type_str = '';
					}
					else {
						if (isset($type) && isset($type_prefix)) {
							$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
						}
						else {
							$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="' . $array_typename . ('[' . $array_type . ']"');
						}
					}
				}
				else if ($use == 'literal') {
					$type_str = '';
				}
				else {
					if (isset($type) && isset($type_prefix)) {
						$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
					}
					else {
						$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="xsd:anyType[0]"';
					}
				}

				$xml = '<' . $name . $xmlns . $type_str . $atts . '>' . $xml . ('</' . $name . '>');
			}
			else {
				$this->debug('serialize_val: serialize struct');
				if (isset($type) && isset($type_prefix)) {
					$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
				}
				else {
					$type_str = '';
				}

				if ($use == 'literal') {
					$xml .= '<' . $name . $xmlns . $atts . '>';
				}
				else {
					$xml .= '<' . $name . $xmlns . $type_str . $atts . '>';
				}

				foreach ($val as $k => $v) {
					if ($type == 'Map' && $type_ns == 'http://xml.apache.org/xml-soap') {
						$xml .= '<item>';
						$xml .= $this->serialize_val($k, 'key', false, false, false, false, $use);
						$xml .= $this->serialize_val($v, 'value', false, false, false, false, $use);
						$xml .= '</item>';
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$xml .= '</' . $name . '>';
			}

			break;

		default:
			$this->debug('serialize_val: serialize unknown');
			$xml .= 'not detected, got ' . gettype($val) . ' for ' . $val;
			break;
		}

		$this->debug('serialize_val returning ' . $xml);
		return $xml;
	}

	/**
    * serializes a message
    *
    * @param string $body the XML of the SOAP body
    * @param mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
    * @param array $namespaces optional the namespaces used in generating the body and headers
    * @param string $style optional (rpc|document)
    * @param string $use optional (encoded|literal)
    * @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
    * @return string the message
    * @access public
    */
	public function serializeEnvelope($body, $headers = false, $namespaces = array(), $style = 'rpc', $use = 'encoded', $encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/')
	{
		$this->debug('In serializeEnvelope length=' . strlen($body) . ' body (max 1000 characters)=' . substr($body, 0, 1000) . (' style=' . $style . ' use=' . $use . ' encodingStyle=' . $encodingStyle));
		$this->debug('headers:');
		$this->appendDebug($this->varDump($headers));
		$this->debug('namespaces:');
		$this->appendDebug($this->varDump($namespaces));
		$ns_string = '';

		foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
			$ns_string .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if ($encodingStyle) {
			$ns_string = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"' . $ns_string;
		}

		if ($headers) {
			if (is_array($headers)) {
				$xml = '';

				foreach ($headers as $k => $v) {
					if (is_object($v) && get_class($v) == 'soapval') {
						$xml .= $this->serialize_val($v, false, false, false, false, false, $use);
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$headers = $xml;
				$this->debug('In serializeEnvelope, serialized array of headers to ' . $headers);
			}

			$headers = '<SOAP-ENV:Header>' . $headers . '</SOAP-ENV:Header>';
		}

		return '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?' . '>' . '<SOAP-ENV:Envelope' . $ns_string . '>' . $headers . '<SOAP-ENV:Body>' . $body . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
	}

	/**
	 * formats a string to be inserted into an HTML stream
	 *
	 * @param string $str The string to format
	 * @return string The formatted string
	 * @access public
	 * @deprecated
	 */
	public function formatDump($str)
	{
		$str = htmlspecialchars($str);
		return nl2br($str);
	}

	/**
	* contracts (changes namespace to prefix) a qualified name
	*
	* @param    string $qname qname
	* @return	string contracted qname
	* @access   private
	*/
	public function contractQname($qname)
	{
		if (strrpos($qname, ':')) {
			$name = substr($qname, strrpos($qname, ':') + 1);
			$ns = substr($qname, 0, strrpos($qname, ':'));
			$p = $this->getPrefixFromNamespace($ns);

			if ($p) {
				return $p . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
	* expands (changes prefix to namespace) a qualified name
	*
	* @param    string $qname qname
	* @return	string expanded qname
	* @access   private
	*/
	public function expandQname($qname)
	{
		if (strpos($qname, ':') && !preg_match('/^http:\\/\\//', $qname)) {
			$name = substr(strstr($qname, ':'), 1);
			$prefix = substr($qname, 0, strpos($qname, ':'));

			if (isset($this->namespaces[$prefix])) {
				return $this->namespaces[$prefix] . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
    * returns the local part of a prefixed string
    * returns the original string, if not prefixed
    *
    * @param string $str The prefixed string
    * @return string The local part
    * @access public
    */
	public function getLocalPart($str)
	{
		if ($sstr = strrchr($str, ':')) {
			return substr($sstr, 1);
		}

		return $str;
	}

	/**
    * returns the prefix part of a prefixed string
    * returns false, if not prefixed
    *
    * @param string $str The prefixed string
    * @return mixed The prefix or false if there is no prefix
    * @access public
    */
	public function getPrefix($str)
	{
		if ($pos = strrpos($str, ':')) {
			return substr($str, 0, $pos);
		}

		return false;
	}

	/**
    * pass it a prefix, it returns a namespace
    *
    * @param string $prefix The prefix
    * @return mixed The namespace, false if no namespace has the specified prefix
    * @access public
    */
	public function getNamespaceFromPrefix($prefix)
	{
		if (isset($this->namespaces[$prefix])) {
			return $this->namespaces[$prefix];
		}

		return false;
	}

	/**
    * returns the prefix for a given namespace (or prefix)
    * or false if no prefixes registered for the given namespace
    *
    * @param string $ns The namespace
    * @return mixed The prefix, false if the namespace has no prefixes
    * @access public
    */
	public function getPrefixFromNamespace($ns)
	{
		foreach ($this->namespaces as $p => $n) {
			if ($ns == $n || $ns == $p) {
				$this->usedNamespaces[$p] = $n;
				return $p;
			}
		}

		return false;
	}

	/**
    * returns the time in ODBC canonical form with microseconds
    *
    * @return string The time in ODBC canonical form with microseconds
    * @access public
    */
	public function getmicrotime()
	{
		if (function_exists('gettimeofday')) {
			$tod = gettimeofday();
			$sec = $tod['sec'];
			$usec = $tod['usec'];
		}
		else {
			$sec = time();
			$usec = 0;
		}

		return strftime('%Y-%m-%d %H:%M:%S', $sec) . '.' . sprintf('%06d', $usec);
	}

	/**
	 * Returns a string with the output of var_dump
	 *
	 * @param mixed $data The variable to var_dump
	 * @return string The output of var_dump
	 * @access public
	 */
	public function varDump($data)
	{
		ob_start();
		var_dump($data);
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	/**
	* represents the object as a string
	*
	* @return	string
	* @access   public
	*/
	public function __toString()
	{
		return $this->varDump($this);
	}
}

class nusoap_client extends nusoap_base
{
	public $username = '';
	public $password = '';
	public $authtype = '';
	public $certRequest = array();
	public $requestHeaders = false;
	public $responseHeaders = '';
	public $responseHeader;
	public $document = '';
	public $endpoint;
	public $forceEndpoint = '';
	public $proxyhost = '';
	public $proxyport = '';
	public $proxyusername = '';
	public $proxypassword = '';
	public $portName = '';
	public $xml_encoding = '';
	public $http_encoding = false;
	public $timeout = 0;
	public $response_timeout = 30;
	public $endpointType = '';
	public $persistentConnection = false;
	public $defaultRpcParams = false;
	public $request = '';
	public $response = '';
	public $responseData = '';
	public $cookies = array();
	public $decode_utf8 = true;
	public $operations = array();
	public $curl_options = array();
	public $bindingType = '';
	public $use_curl = false;
	/**
	 * @var      fault
	 * @access   public
	 */
	public $fault;
	/**
	 * @var      faultcode
	 * @access   public
	 */
	public $faultcode;
	/**
	 * @var      faultstring
	 * @access   public
	 */
	public $faultstring;
	/**
	 * @var      faultdetail
	 * @access   public
	 */
	public $faultdetail;
	/**
	 * Identification for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $title = 'NuSOAP';
	/**
	 * Version for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $version = '0.9.5';
	/**
	 * CVS revision for HTTP headers.
	 *
	 * @var string
	 * @access private
	 */
	public $revision = '$Revision: 1.123 $';
	/**
     * Current error string (manipulated by getError/setError)
	 *
	 * @var string
	 * @access private
	 */
	public $error_str = '';
	/**
     * Current debug string (manipulated by debug/appendDebug/clearDebug/getDebug/getDebugAsXMLComment)
	 *
	 * @var string
	 * @access private
	 */
	public $debug_str = '';
	/**
	 * toggles automatic encoding of special characters as entities
	 * (should always be true, I think)
	 *
	 * @var boolean
	 * @access private
	 */
	public $charencoding = true;
	/**
	 * the debug level for this instance
	 *
	 * @var	integer
	 * @access private
	 */
	public $debugLevel;
	/**
	* set schema version
	*
	* @var      string
	* @access   public
	*/
	public $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';
	/**
	* charset encoding for outgoing messages
	*
	* @var      string
	* @access   public
	*/
	public $soap_defencoding = 'ISO-8859-1';
	/**
	* namespaces in an array of prefix => uri
	*
	* this is "seeded" by a set of constants, but it may be altered by code
	*
	* @var      array
	* @access   public
	*/
	public $namespaces = array('SOAP-ENV' => 'http://schemas.xmlsoap.org/soap/envelope/', 'xsd' => 'http://www.w3.org/2001/XMLSchema', 'xsi' => 'http://www.w3.org/2001/XMLSchema-instance', 'SOAP-ENC' => 'http://schemas.xmlsoap.org/soap/encoding/');
	/**
	* namespaces used in the current context, e.g. during serialization
	*
	* @var      array
	* @access   private
	*/
	public $usedNamespaces = array();
	/**
	* XML Schema types in an array of uri => (array of xml type => php type)
	* is this legacy yet?
	* no, this is used by the nusoap_xmlschema class to verify type => namespace mappings.
	* @var      array
	* @access   public
	*/
	public $typemap = array(
		'http://www.w3.org/2001/XMLSchema'          => array('string' => 'string', 'boolean' => 'boolean', 'float' => 'double', 'double' => 'double', 'decimal' => 'double', 'duration' => '', 'dateTime' => 'string', 'time' => 'string', 'date' => 'string', 'gYearMonth' => '', 'gYear' => '', 'gMonthDay' => '', 'gDay' => '', 'gMonth' => '', 'hexBinary' => 'string', 'base64Binary' => 'string', 'anyType' => 'string', 'anySimpleType' => 'string', 'normalizedString' => 'string', 'token' => 'string', 'language' => '', 'NMTOKEN' => '', 'NMTOKENS' => '', 'Name' => '', 'NCName' => '', 'ID' => '', 'IDREF' => '', 'IDREFS' => '', 'ENTITY' => '', 'ENTITIES' => '', 'integer' => 'integer', 'nonPositiveInteger' => 'integer', 'negativeInteger' => 'integer', 'long' => 'integer', 'int' => 'integer', 'short' => 'integer', 'byte' => 'integer', 'nonNegativeInteger' => 'integer', 'unsignedLong' => '', 'unsignedInt' => '', 'unsignedShort' => '', 'unsignedByte' => '', 'positiveInteger' => ''),
		'http://www.w3.org/2000/10/XMLSchema'       => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://www.w3.org/1999/XMLSchema'          => array('i4' => '', 'int' => 'integer', 'boolean' => 'boolean', 'string' => 'string', 'double' => 'double', 'float' => 'double', 'dateTime' => 'string', 'timeInstant' => 'string', 'base64Binary' => 'string', 'base64' => 'string', 'ur-type' => 'array'),
		'http://soapinterop.org/xsd'                => array('SOAPStruct' => 'struct'),
		'http://schemas.xmlsoap.org/soap/encoding/' => array('base64' => 'string', 'array' => 'array', 'Array' => 'array'),
		'http://xml.apache.org/xml-soap'            => array('Map')
		);
	/**
	* XML entities to convert
	*
	* @var      array
	* @access   public
	* @deprecated
	* @see	expandEntities
	*/
	public $xmlEntities = array('quot' => '"', 'amp' => '&', 'lt' => '<', 'gt' => '>', 'apos' => '\'');

	/**
	* constructor
	*
	* @param    mixed $endpoint SOAP server or WSDL URL (string), or wsdl instance (object)
	* @param    mixed $wsdl optional, set to 'wsdl' or true if using WSDL
	* @param    string $proxyhost optional
	* @param    string $proxyport optional
	* @param	string $proxyusername optional
	* @param	string $proxypassword optional
	* @param	integer $timeout set the connection timeout
	* @param	integer $response_timeout set the response timeout
	* @param	string $portName optional portName in WSDL document
	* @access   public
	*/
	public function nusoap_client($endpoint, $wsdl = false, $proxyhost = false, $proxyport = false, $proxyusername = false, $proxypassword = false, $timeout = 0, $response_timeout = 30, $portName = '')
	{
		parent::nusoap_base();
		$this->endpoint = $endpoint;
		$this->proxyhost = $proxyhost;
		$this->proxyport = $proxyport;
		$this->proxyusername = $proxyusername;
		$this->proxypassword = $proxypassword;
		$this->timeout = $timeout;
		$this->response_timeout = $response_timeout;
		$this->portName = $portName;
		$this->debug('ctor wsdl=' . $wsdl . ' timeout=' . $timeout . ' response_timeout=' . $response_timeout);
		$this->appendDebug('endpoint=' . $this->varDump($endpoint));

		if ($wsdl) {
			if (is_object($endpoint) && get_class($endpoint) == 'wsdl') {
				$this->wsdl = $endpoint;
				$this->endpoint = $this->wsdl->wsdl;
				$this->wsdlFile = $this->endpoint;
				$this->debug('existing wsdl instance created from ' . $this->endpoint);
				$this->checkWSDL();
			}
			else {
				$this->wsdlFile = $this->endpoint;
				$this->wsdl = NULL;
				$this->debug('will use lazy evaluation of wsdl from ' . $this->endpoint);
			}

			$this->endpointType = 'wsdl';
			return NULL;
		}

		$this->debug('instantiate SOAP with endpoint at ' . $endpoint);
		$this->endpointType = 'soap';
	}

	/**
	* calls method, returns PHP native type
	*
	* @param    string $operation SOAP server URL or path
	* @param    mixed $params An array, associative or simple, of the parameters
	*			              for the method call, or a string that is the XML
	*			              for the call.  For rpc style, this call will
	*			              wrap the XML in a tag named after the method, as
	*			              well as the SOAP Envelope and Body.  For document
	*			              style, this will only wrap with the Envelope and Body.
	*			              IMPORTANT: when using an array with document style,
	*			              in which case there
	*                         is really one parameter, the root of the fragment
	*                         used in the call, which encloses what programmers
	*                         normally think of parameters.  A parameter array
	*                         *must* include the wrapper.
	* @param	string $namespace optional method namespace (WSDL can override)
	* @param	string $soapAction optional SOAPAction value (WSDL can override)
	* @param	mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
	* @param	boolean $rpcParams optional (no longer used)
	* @param	string	$style optional (rpc|document) the style to use when serializing parameters (WSDL can override)
	* @param	string	$use optional (encoded|literal) the use when serializing parameters (WSDL can override)
	* @return	mixed	response from SOAP call, normally an associative array mirroring the structure of the XML response, false for certain fatal errors
	* @access   public
	*/
	public function call($operation, $params = array(), $namespace = 'http://tempuri.org', $soapAction = '', $headers = false, $rpcParams = NULL, $style = 'rpc', $use = 'encoded')
	{
		$this->operation = $operation;
		$this->fault = false;
		$this->setError('');
		$this->request = '';
		$this->response = '';
		$this->responseData = '';
		$this->faultstring = '';
		$this->faultcode = '';
		$this->opData = array();
		$this->debug('call: operation=' . $operation . ', namespace=' . $namespace . ', soapAction=' . $soapAction . ', rpcParams=' . $rpcParams . ', style=' . $style . ', use=' . $use . ', endpointType=' . $this->endpointType);
		$this->appendDebug('params=' . $this->varDump($params));
		$this->appendDebug('headers=' . $this->varDump($headers));

		if ($headers) {
			$this->requestHeaders = $headers;
		}

		if ($this->endpointType == 'wsdl' && is_null($this->wsdl)) {
			$this->loadWSDL();

			if ($this->getError()) {
				return false;
			}
		}

		if ($this->endpointType == 'wsdl' && ($opData = $this->getOperationData($operation))) {
			$this->opData = $opData;
			$this->debug('found operation');
			$this->appendDebug('opData=' . $this->varDump($opData));

			if (isset($opData['soapAction'])) {
				$soapAction = $opData['soapAction'];
			}

			if (!$this->forceEndpoint) {
				$this->endpoint = $opData['endpoint'];
			}
			else {
				$this->endpoint = $this->forceEndpoint;
			}

			$namespace = isset($opData['input']['namespace']) ? $opData['input']['namespace'] : $namespace;
			$style = $opData['style'];
			$use = $opData['input']['use'];
			if ($namespace != '' && !isset($this->wsdl->namespaces[$namespace])) {
				$nsPrefix = 'ns' . rand(1000, 9999);
				$this->wsdl->namespaces[$nsPrefix] = $namespace;
			}

			$nsPrefix = $this->wsdl->getPrefixFromNamespace($namespace);

			if (is_string($params)) {
				$this->debug('serializing param string for WSDL operation ' . $operation);
				$payload = $params;
			}
			else if (is_array($params)) {
				$this->debug('serializing param array for WSDL operation ' . $operation);
				$payload = $this->wsdl->serializeRPCParameters($operation, 'input', $params, $this->bindingType);
			}
			else {
				$this->debug('params must be array or string');
				$this->setError('params must be array or string');
				return false;
			}

			$usedNamespaces = $this->wsdl->usedNamespaces;

			if (isset($opData['input']['encodingStyle'])) {
				$encodingStyle = $opData['input']['encodingStyle'];
			}
			else {
				$encodingStyle = '';
			}

			$this->appendDebug($this->wsdl->getDebug());
			$this->wsdl->clearDebug();

			if ($errstr = $this->wsdl->getError()) {
				$this->debug('got wsdl error: ' . $errstr);
				$this->setError('wsdl error: ' . $errstr);
				return false;
			}
		}
		else {
			if ($this->endpointType == 'wsdl') {
				$this->appendDebug($this->wsdl->getDebug());
				$this->wsdl->clearDebug();
				$this->setError('operation ' . $operation . ' not present in WSDL.');
				$this->debug('operation \'' . $operation . '\' not present in WSDL.');
				return false;
			}

			$nsPrefix = 'ns' . rand(1000, 9999);
			$payload = '';

			if (is_string($params)) {
				$this->debug('serializing param string for operation ' . $operation);
				$payload = $params;
			}
			else if (is_array($params)) {
				$this->debug('serializing param array for operation ' . $operation);

				foreach ($params as $k => $v) {
					$payload .= $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}
			else {
				$this->debug('params must be array or string');
				$this->setError('params must be array or string');
				return false;
			}

			$usedNamespaces = array();

			if ($use == 'encoded') {
				$encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/';
			}
			else {
				$encodingStyle = '';
			}
		}

		if ($style == 'rpc') {
			if ($use == 'literal') {
				$this->debug('wrapping RPC request with literal method element');

				if ($namespace) {
					$payload = '<' . $nsPrefix . ':' . $operation . ' xmlns:' . $nsPrefix . '="' . $namespace . '">' . $payload . ('</' . $nsPrefix . ':' . $operation . '>');
				}
				else {
					$payload = '<' . $operation . '>' . $payload . ('</' . $operation . '>');
				}
			}
			else {
				$this->debug('wrapping RPC request with encoded method element');

				if ($namespace) {
					$payload = '<' . $nsPrefix . ':' . $operation . ' xmlns:' . $nsPrefix . '="' . $namespace . '">' . $payload . ('</' . $nsPrefix . ':' . $operation . '>');
				}
				else {
					$payload = '<' . $operation . '>' . $payload . ('</' . $operation . '>');
				}
			}
		}

		$soapmsg = $this->serializeEnvelope($payload, $this->requestHeaders, $usedNamespaces, $style, $use, $encodingStyle);
		$this->debug('endpoint=' . $this->endpoint . ', soapAction=' . $soapAction . ', namespace=' . $namespace . ', style=' . $style . ', use=' . $use . ', encodingStyle=' . $encodingStyle);
		$this->debug('SOAP message length=' . strlen($soapmsg) . ' contents (max 1000 bytes)=' . substr($soapmsg, 0, 1000));
		$return = $this->send($this->getHTTPBody($soapmsg), $soapAction, $this->timeout, $this->response_timeout);

		if ($errstr = $this->getError()) {
			$this->debug('Error: ' . $errstr);
			return false;
		}

		$this->return = $return;
		$this->debug('sent message successfully and got a(n) ' . gettype($return));
		$this->appendDebug('return=' . $this->varDump($return));
		if (is_array($return) && isset($return['faultcode'])) {
			$this->debug('got fault');
			$this->setError($return['faultcode'] . ': ' . $return['faultstring']);
			$this->fault = true;

			foreach ($return as $k => $v) {
				$this->$k = $v;
				$this->debug($k . ' = ' . $v . '<br>');
			}

			return $return;
		}

		if ($style == 'document') {
			return $return;
		}

		if (is_array($return)) {
			if (1 < sizeof($return)) {
				return $return;
			}

			$return = array_shift($return);
			$this->debug('return shifted value: ');
			$this->appendDebug($this->varDump($return));
			return $return;
		}

		return '';
	}

	/**
	* check WSDL passed as an instance or pulled from an endpoint
	*
	* @access   private
	*/
	public function checkWSDL()
	{
		$this->appendDebug($this->wsdl->getDebug());
		$this->wsdl->clearDebug();
		$this->debug('checkWSDL');

		if ($errstr = $this->wsdl->getError()) {
			$this->appendDebug($this->wsdl->getDebug());
			$this->wsdl->clearDebug();
			$this->debug('got wsdl error: ' . $errstr);
			$this->setError('wsdl error: ' . $errstr);
			return NULL;
		}

		if ($this->operations = $this->wsdl->getOperations($this->portName, 'soap')) {
			$this->appendDebug($this->wsdl->getDebug());
			$this->wsdl->clearDebug();
			$this->bindingType = 'soap';
			$this->debug('got ' . count($this->operations) . ' operations from wsdl ' . $this->wsdlFile . ' for binding type ' . $this->bindingType);
			return NULL;
		}

		if ($this->operations = $this->wsdl->getOperations($this->portName, 'soap12')) {
			$this->appendDebug($this->wsdl->getDebug());
			$this->wsdl->clearDebug();
			$this->bindingType = 'soap12';
			$this->debug('got ' . count($this->operations) . ' operations from wsdl ' . $this->wsdlFile . ' for binding type ' . $this->bindingType);
			$this->debug('**************** WARNING: SOAP 1.2 BINDING *****************');
			return NULL;
		}

		$this->appendDebug($this->wsdl->getDebug());
		$this->wsdl->clearDebug();
		$this->debug('getOperations returned false');
		$this->setError('no operations defined in the WSDL document!');
	}

	/**
	 * instantiate wsdl object and parse wsdl file
	 *
	 * @access	public
	 */
	public function loadWSDL()
	{
		$this->debug('instantiating wsdl class with doc: ' . $this->wsdlFile);
		$this->wsdl = new wsdl('', $this->proxyhost, $this->proxyport, $this->proxyusername, $this->proxypassword, $this->timeout, $this->response_timeout, $this->curl_options, $this->use_curl);
		$this->wsdl->setCredentials($this->username, $this->password, $this->authtype, $this->certRequest);
		$this->wsdl->fetchWSDL($this->wsdlFile);
		$this->checkWSDL();
	}

	/**
	* get available data pertaining to an operation
	*
	* @param    string $operation operation name
	* @return	array array of data pertaining to the operation
	* @access   public
	*/
	public function getOperationData($operation)
	{
		if ($this->endpointType == 'wsdl' && is_null($this->wsdl)) {
			$this->loadWSDL();

			if ($this->getError()) {
				return false;
			}
		}

		if (isset($this->operations[$operation])) {
			return $this->operations[$operation];
		}

		$this->debug('No data for operation: ' . $operation);
	}

	/**
    * send the SOAP message
    *
    * Note: if the operation has multiple return values
    * the return value of this method will be an array
    * of those values.
    *
	* @param    string $msg a SOAPx4 soapmsg object
	* @param    string $soapaction SOAPAction value
	* @param    integer $timeout set connection timeout in seconds
	* @param	integer $response_timeout set response timeout in seconds
	* @return	mixed native PHP types.
	* @access   private
	*/
	public function send($msg, $soapaction = '', $timeout = 0, $response_timeout = 30)
	{
		$this->checkCookies();

		switch (true) {
		case preg_match('/^http/', $this->endpoint):
			$this->debug('transporting via HTTP');
			if ($this->persistentConnection == true && is_object($this->persistentConnection)) {
				$http = &$this->persistentConnection;
			}
			else {
				$http = new soap_transport_http($this->endpoint, $this->curl_options, $this->use_curl);

				if ($this->persistentConnection) {
					$http->usePersistentConnection();
				}
			}

			$http->setContentType($this->getHTTPContentType(), $this->getHTTPContentTypeCharset());
			$http->setSOAPAction($soapaction);
			if ($this->proxyhost && $this->proxyport) {
				$http->setProxy($this->proxyhost, $this->proxyport, $this->proxyusername, $this->proxypassword);
			}

			if ($this->authtype != '') {
				$http->setCredentials($this->username, $this->password, $this->authtype, array(), $this->certRequest);
			}

			if ($this->http_encoding != '') {
				$http->setEncoding($this->http_encoding);
			}

			$this->debug('sending message, length=' . strlen($msg));

			if (preg_match('/^http:/', $this->endpoint)) {
				$this->responseData = $http->send($msg, $timeout, $response_timeout, $this->cookies);
			}
			else if (preg_match('/^https/', $this->endpoint)) {
				$this->responseData = $http->sendHTTPS($msg, $timeout, $response_timeout, $this->cookies);
			}
			else {
				$this->setError('no http/s in endpoint url');
			}

			$this->request = $http->outgoing_payload;
			$this->response = $http->incoming_payload;
			$this->appendDebug($http->getDebug());
			$this->UpdateCookies($http->incoming_cookies);

			if ($this->persistentConnection) {
				$http->clearDebug();

				if (!is_object($this->persistentConnection)) {
					$this->persistentConnection = $http;
				}
			}

			if ($err = $http->getError()) {
				$this->setError('HTTP Error: ' . $err);
				return false;
			}

			if ($this->getError()) {
				return false;
			}

			$this->debug('got response, length=' . strlen($this->responseData) . ' type=' . $http->incoming_headers['content-type']);
			return $this->parseResponse($http->incoming_headers, $this->responseData);
		default:
			$this->setError('no transport found, or selected transport is not yet supported!');
		}

		return false;
	}

	/**
	* processes SOAP message returned from server
	*
	* @param	array	$headers	The HTTP headers
	* @param	string	$data		unprocessed response data from server
	* @return	mixed	value of the message, decoded into a PHP type
	* @access   private
	*/
	public function parseResponse($headers, $data)
	{
		$this->debug('Entering parseResponse() for data of length ' . strlen($data) . ' headers:');
		$this->appendDebug($this->varDump($headers));

		if (!isset($headers['content-type'])) {
			$this->setError('Response not of type text/xml (no content-type header)');
			return false;
		}

		if (!strstr($headers['content-type'], 'text/xml')) {
			$this->setError('Response not of type text/xml: ' . $headers['content-type']);
			return false;
		}

		if (strpos($headers['content-type'], '=')) {
			$enc = str_replace('"', '', substr(strstr($headers['content-type'], '='), 1));
			$this->debug('Got response encoding: ' . $enc);

			if (preg_match('/^(ISO-8859-1|US-ASCII|UTF-8)$/i', $enc)) {
				$this->xml_encoding = strtoupper($enc);
			}
			else {
				$this->xml_encoding = 'US-ASCII';
			}
		}
		else {
			$this->xml_encoding = 'ISO-8859-1';
		}

		$this->debug('Use encoding: ' . $this->xml_encoding . ' when creating nusoap_parser');
		$parser = new nusoap_parser($data, $this->xml_encoding, $this->operation, $this->decode_utf8);
		$this->appendDebug($parser->getDebug());

		if ($errstr = $parser->getError()) {
			$this->setError($errstr);
			unset($parser);
			return false;
		}

		$this->responseHeaders = $parser->getHeaders();
		$this->responseHeader = $parser->get_soapheader();
		$return = $parser->get_soapbody();
		$this->document = $parser->document;
		unset($parser);
		return $return;
	}

	/**
	* sets user-specified cURL options
	*
	* @param	mixed $option The cURL option (always integer?)
	* @param	mixed $value The cURL option value
	* @access   public
	*/
	public function setCurlOption($option, $value)
	{
		$this->debug('setCurlOption option=' . $option . ', value=');
		$this->appendDebug($this->varDump($value));
		$this->curl_options[$option] = $value;
	}

	/**
	* sets the SOAP endpoint, which can override WSDL
	*
	* @param	string $endpoint The endpoint URL to use, or empty string or false to prevent override
	* @access   public
	*/
	public function setEndpoint($endpoint)
	{
		$this->debug('setEndpoint("' . $endpoint . '")');
		$this->forceEndpoint = $endpoint;
	}

	/**
	* set the SOAP headers
	*
	* @param	mixed $headers String of XML with SOAP header content, or array of soapval objects for SOAP headers
	* @access   public
	*/
	public function setHeaders($headers)
	{
		$this->debug('setHeaders headers=');
		$this->appendDebug($this->varDump($headers));
		$this->requestHeaders = $headers;
	}

	/**
	* get the SOAP response headers (namespace resolution incomplete)
	*
	* @return	string
	* @access   public
	*/
	public function getHeaders()
	{
		return $this->responseHeaders;
	}

	/**
	* get the SOAP response Header (parsed)
	*
	* @return	mixed
	* @access   public
	*/
	public function getHeader()
	{
		return $this->responseHeader;
	}

	/**
	* set proxy info here
	*
	* @param    string $proxyhost
	* @param    string $proxyport
	* @param	string $proxyusername
	* @param	string $proxypassword
	* @access   public
	*/
	public function setHTTPProxy($proxyhost, $proxyport, $proxyusername = '', $proxypassword = '')
	{
		$this->proxyhost = $proxyhost;
		$this->proxyport = $proxyport;
		$this->proxyusername = $proxyusername;
		$this->proxypassword = $proxypassword;
	}

	/**
	* if authenticating, set user credentials here
	*
	* @param    string $username
	* @param    string $password
	* @param	string $authtype (basic|digest|certificate|ntlm)
	* @param	array $certRequest (keys must be cainfofile (optional), sslcertfile, sslkeyfile, passphrase, verifypeer (optional), verifyhost (optional): see corresponding options in cURL docs)
	* @access   public
	*/
	public function setCredentials($username, $password, $authtype = 'basic', $certRequest = array())
	{
		$this->debug('setCredentials username=' . $username . ' authtype=' . $authtype . ' certRequest=');
		$this->appendDebug($this->varDump($certRequest));
		$this->username = $username;
		$this->password = $password;
		$this->authtype = $authtype;
		$this->certRequest = $certRequest;
	}

	/**
	* use HTTP encoding
	*
	* @param    string $enc HTTP encoding
	* @access   public
	*/
	public function setHTTPEncoding($enc = 'gzip, deflate')
	{
		$this->debug('setHTTPEncoding("' . $enc . '")');
		$this->http_encoding = $enc;
	}

	/**
	* Set whether to try to use cURL connections if possible
	*
	* @param	boolean $use Whether to try to use cURL
	* @access   public
	*/
	public function setUseCURL($use)
	{
		$this->debug('setUseCURL(' . $use . ')');
		$this->use_curl = $use;
	}

	/**
	* use HTTP persistent connections if possible
	*
	* @access   public
	*/
	public function useHTTPPersistentConnection()
	{
		$this->debug('useHTTPPersistentConnection');
		$this->persistentConnection = true;
	}

	/**
	* gets the default RPC parameter setting.
	* If true, default is that call params are like RPC even for document style.
	* Each call() can override this value.
	*
	* This is no longer used.
	*
	* @return boolean
	* @access public
	* @deprecated
	*/
	public function getDefaultRpcParams()
	{
		return $this->defaultRpcParams;
	}

	/**
	* sets the default RPC parameter setting.
	* If true, default is that call params are like RPC even for document style
	* Each call() can override this value.
	*
	* This is no longer used.
	*
	* @param    boolean $rpcParams
	* @access public
	* @deprecated
	*/
	public function setDefaultRpcParams($rpcParams)
	{
		$this->defaultRpcParams = $rpcParams;
	}

	/**
	* dynamically creates an instance of a proxy class,
	* allowing user to directly call methods from wsdl
	*
	* @return   object soap_proxy object
	* @access   public
	*/
	public function getProxy()
	{
		$r = rand();
		$evalStr = $this->_getProxyClassCode($r);

		if ($this->getError()) {
			$this->debug('Error from _getProxyClassCode, so return NULL');
			return NULL;
		}

		eval ($evalStr);
		eval ('$proxy = new nusoap_proxy_' . $r . '(\'\');');
		$proxy->endpointType = 'wsdl';
		$proxy->wsdlFile = $this->wsdlFile;
		$proxy->wsdl = $this->wsdl;
		$proxy->operations = $this->operations;
		$proxy->defaultRpcParams = $this->defaultRpcParams;
		$proxy->soap_defencoding = $this->soap_defencoding;
		$proxy->username = $this->username;
		$proxy->password = $this->password;
		$proxy->authtype = $this->authtype;
		$proxy->certRequest = $this->certRequest;
		$proxy->requestHeaders = $this->requestHeaders;
		$proxy->endpoint = $this->endpoint;
		$proxy->forceEndpoint = $this->forceEndpoint;
		$proxy->proxyhost = $this->proxyhost;
		$proxy->proxyport = $this->proxyport;
		$proxy->proxyusername = $this->proxyusername;
		$proxy->proxypassword = $this->proxypassword;
		$proxy->http_encoding = $this->http_encoding;
		$proxy->timeout = $this->timeout;
		$proxy->response_timeout = $this->response_timeout;
		$proxy->persistentConnection = &$this->persistentConnection;
		$proxy->decode_utf8 = $this->decode_utf8;
		$proxy->curl_options = $this->curl_options;
		$proxy->bindingType = $this->bindingType;
		$proxy->use_curl = $this->use_curl;
		return $proxy;
	}

	/**
	* dynamically creates proxy class code
	*
	* @return   string PHP/NuSOAP code for the proxy class
	* @access   private
	*/
	public function _getProxyClassCode($r)
	{
		$this->debug('in getProxy endpointType=' . $this->endpointType);
		$this->appendDebug('wsdl=' . $this->varDump($this->wsdl));

		if ($this->endpointType != 'wsdl') {
			$evalStr = 'A proxy can only be created for a WSDL client';
			$this->setError($evalStr);
			$evalStr = 'echo "' . $evalStr . '";';
			return $evalStr;
		}

		if ($this->endpointType == 'wsdl' && is_null($this->wsdl)) {
			$this->loadWSDL();

			if ($this->getError()) {
				return 'echo "' . $this->getError() . '";';
			}
		}

		$evalStr = '';

		foreach ($this->operations as $operation => $opData) {
			if ($operation != '') {
				if (0 < sizeof($opData['input']['parts'])) {
					$paramStr = '';
					$paramArrayStr = '';
					$paramCommentStr = '';

					foreach ($opData['input']['parts'] as $name => $type) {
						$paramStr .= '$' . $name . ', ';
						$paramArrayStr .= '\'' . $name . '\' => $' . $name . ', ';
						$paramCommentStr .= $type . ' $' . $name . ', ';
					}

					$paramStr = substr($paramStr, 0, strlen($paramStr) - 2);
					$paramArrayStr = substr($paramArrayStr, 0, strlen($paramArrayStr) - 2);
					$paramCommentStr = substr($paramCommentStr, 0, strlen($paramCommentStr) - 2);
				}
				else {
					$paramStr = '';
					$paramArrayStr = '';
					$paramCommentStr = 'void';
				}

				$opData['namespace'] = !isset($opData['namespace']) ? 'http://testuri.com' : $opData['namespace'];
				$evalStr .= '// ' . $paramCommentStr . "\r\n\tfunction " . str_replace('.', '__', $operation) . ('(' . $paramStr . ") {\r\n\t\t\$params = array(" . $paramArrayStr . ");\r\n\t\treturn \$this->call('" . $operation . '\', $params, \'') . $opData['namespace'] . '\', \'' . (isset($opData['soapAction']) ? $opData['soapAction'] : '') . "');\r\n\t}\r\n\t";
				unset($paramStr);
				unset($paramCommentStr);
			}
		}

		$evalStr = 'class nusoap_proxy_' . $r . " extends nusoap_client {\r\n\t" . $evalStr . "\r\n}";
		return $evalStr;
	}

	/**
	* dynamically creates proxy class code
	*
	* @return   string PHP/NuSOAP code for the proxy class
	* @access   public
	*/
	public function getProxyClassCode()
	{
		$r = rand();
		return $this->_getProxyClassCode($r);
	}

	/**
	* gets the HTTP body for the current request.
	*
	* @param string $soapmsg The SOAP payload
	* @return string The HTTP body, which includes the SOAP payload
	* @access private
	*/
	public function getHTTPBody($soapmsg)
	{
		return $soapmsg;
	}

	/**
	* gets the HTTP content type for the current request.
	*
	* Note: getHTTPBody must be called before this.
	*
	* @return string the HTTP content type for the current request.
	* @access private
	*/
	public function getHTTPContentType()
	{
		return 'text/xml';
	}

	/**
	* gets the HTTP content type charset for the current request.
	* returns false for non-text content types.
	*
	* Note: getHTTPBody must be called before this.
	*
	* @return string the HTTP content type charset for the current request.
	* @access private
	*/
	public function getHTTPContentTypeCharset()
	{
		return $this->soap_defencoding;
	}

	public function decodeUTF8($bool)
	{
		$this->decode_utf8 = $bool;
		return true;
	}

	/**
	 * adds a new Cookie into $this->cookies array
	 *
	 * @param	string $name Cookie Name
	 * @param	string $value Cookie Value
	 * @return	boolean if cookie-set was successful returns true, else false
	 * @access	public
	 */
	public function setCookie($name, $value)
	{
		if (strlen($name) == 0) {
			return false;
		}

		$this->cookies[] = array('name' => $name, 'value' => $value);
		return true;
	}

	/**
	 * gets all Cookies
	 *
	 * @return   array with all internal cookies
	 * @access   public
	 */
	public function getCookies()
	{
		return $this->cookies;
	}

	/**
	 * checks all Cookies and delete those which are expired
	 *
	 * @return   boolean always return true
	 * @access   private
	 */
	public function checkCookies()
	{
		if (sizeof($this->cookies) == 0) {
			return true;
		}

		$this->debug('checkCookie: check ' . sizeof($this->cookies) . ' cookies');
		$curr_cookies = $this->cookies;
		$this->cookies = array();

		foreach ($curr_cookies as $cookie) {
			if (!is_array($cookie)) {
				$this->debug('Remove cookie that is not an array');
				continue;
			}

			if (isset($cookie['expires']) && !empty($cookie['expires'])) {
				if (time() < strtotime($cookie['expires'])) {
					$this->cookies[] = $cookie;
				}
				else {
					$this->debug('Remove expired cookie ' . $cookie['name']);
				}
			}
			else {
				$this->cookies[] = $cookie;
			}
		}

		$this->debug('checkCookie: ' . sizeof($this->cookies) . ' cookies left in array');
		return true;
	}

	/**
	 * updates the current cookies with a new set
	 *
	 * @param	array $cookies new cookies with which to update current ones
	 * @return	boolean always return true
	 * @access	private
	 */
	public function UpdateCookies($cookies)
	{
		if (sizeof($this->cookies) == 0) {
			if (0 < sizeof($cookies)) {
				$this->debug('Setting new cookie(s)');
				$this->cookies = $cookies;
			}

			return true;
		}

		if (sizeof($cookies) == 0) {
			return true;
		}

		foreach ($cookies as $newCookie) {
			if (!is_array($newCookie)) {
				continue;
			}

			if (!isset($newCookie['name']) || !isset($newCookie['value'])) {
				continue;
			}

			$newName = $newCookie['name'];
			$found = false;
			$i = 0;

			while ($i < count($this->cookies)) {
				$cookie = $this->cookies[$i];

				if (!is_array($cookie)) {
					continue;
				}

				if (!isset($cookie['name'])) {
					continue;
				}

				if ($newName != $cookie['name']) {
					continue;
				}

				$newDomain = isset($newCookie['domain']) ? $newCookie['domain'] : 'NODOMAIN';
				$domain = isset($cookie['domain']) ? $cookie['domain'] : 'NODOMAIN';

				if ($newDomain != $domain) {
					continue;
				}

				$newPath = isset($newCookie['path']) ? $newCookie['path'] : 'NOPATH';
				$path = isset($cookie['path']) ? $cookie['path'] : 'NOPATH';

				if ($newPath != $path) {
					continue;
				}

				$this->cookies[$i] = $newCookie;
				$found = true;
				$this->debug('Update cookie ' . $newName . '=' . $newCookie['value']);
				break;
				++$i;
			}

			if (!$found) {
				$this->debug('Add cookie ' . $newName . '=' . $newCookie['value']);
				$this->cookies[] = $newCookie;
			}
		}

		return true;
	}

	/**
	* constructor
	*
	* @access	public
	*/
	public function nusoap_base()
	{
		$this->debugLevel = $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* gets the global debug level, which applies to future instances
	*
	* @return	integer	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getGlobalDebugLevel()
	{
		return $GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'];
	}

	/**
	* sets the global debug level, which applies to future instances
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setGlobalDebugLevel($level)
	{
		$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = $level;
	}

	/**
	* gets the debug level for this instance
	*
	* @return	int	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}

	/**
	* sets the debug level for this instance
	*
	* @param	int	$level	Debug level 0-9, where 0 turns off
	* @access	public
	*/
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}

	/**
	* adds debug data to the instance debug string with formatting
	*
	* @param    string $string debug data
	* @access   private
	*/
	public function debug($string)
	{
		if (0 < $this->debugLevel) {
			$this->appendDebug($this->getmicrotime() . ' ' . get_class($this) . (': ' . $string . "\n"));
		}
	}

	/**
	* adds debug data to the instance debug string without formatting
	*
	* @param    string $string debug data
	* @access   public
	*/
	public function appendDebug($string)
	{
		if (0 < $this->debugLevel) {
			$this->debug_str .= $string;
		}
	}

	/**
	* clears the current debug data for this instance
	*
	* @access   public
	*/
	public function clearDebug()
	{
		$this->debug_str = '';
	}

	/**
	* gets the current debug data for this instance
	*
	* @return   debug data
	* @access   public
	*/
	public function& getDebug()
	{
		return $this->debug_str;
	}

	/**
	* gets the current debug data for this instance as an XML comment
	* this may change the contents of the debug data
	*
	* @return   debug data as an XML comment
	* @access   public
	*/
	public function& getDebugAsXMLComment()
	{
		while (strpos($this->debug_str, '--')) {
			$this->debug_str = str_replace('--', '- -', $this->debug_str);
		}

		$ret = "<!--\n" . $this->debug_str . "\n-->";
		return $ret;
	}

	/**
	* expands entities, e.g. changes '<' to '&lt;'.
	*
	* @param	string	$val	The string in which to expand entities.
	* @access	private
	*/
	public function expandEntities($val)
	{
		if ($this->charencoding) {
			$val = str_replace('&', '&amp;', $val);
			$val = str_replace('\'', '&apos;', $val);
			$val = str_replace('"', '&quot;', $val);
			$val = str_replace('<', '&lt;', $val);
			$val = str_replace('>', '&gt;', $val);
		}

		return $val;
	}

	/**
	* returns error string if present
	*
	* @return   mixed error string or false
	* @access   public
	*/
	public function getError()
	{
		if ($this->error_str != '') {
			return $this->error_str;
		}

		return false;
	}

	/**
	* sets error string
	*
	* @return   boolean $string error string
	* @access   private
	*/
	public function setError($str)
	{
		$this->error_str = $str;
	}

	/**
	* detect if array is a simple array or a struct (associative array)
	*
	* @param	mixed	$val	The PHP array
	* @return	string	(arraySimple|arrayStruct)
	* @access	private
	*/
	public function isArraySimpleOrStruct($val)
	{
		$keyList = array_keys($val);

		foreach ($keyList as $keyListValue) {
			if (!is_int($keyListValue)) {
				return 'arrayStruct';
			}
		}

		return 'arraySimple';
	}

	/**
	* serializes PHP values in accordance w/ section 5. Type information is
	* not serialized if $use == 'literal'.
	*
	* @param	mixed	$val	The value to serialize
	* @param	string	$name	The name (local part) of the XML element
	* @param	string	$type	The XML schema type (local part) for the element
	* @param	string	$name_ns	The namespace for the name of the XML element
	* @param	string	$type_ns	The namespace for the type of the element
	* @param	array	$attributes	The attributes to serialize as name=>value pairs
	* @param	string	$use	The WSDL "use" (encoded|literal)
	* @param	boolean	$soapval	Whether this is called from soapval.
	* @return	string	The serialized element, possibly with child elements
    * @access	public
	*/
	public function serialize_val($val, $name = false, $type = false, $name_ns = false, $type_ns = false, $attributes = false, $use = 'encoded', $soapval = false)
	{
		$this->debug('in serialize_val: name=' . $name . ', type=' . $type . ', name_ns=' . $name_ns . ', type_ns=' . $type_ns . ', use=' . $use . ', soapval=' . $soapval);
		$this->appendDebug('value=' . $this->varDump($val));
		$this->appendDebug('attributes=' . $this->varDump($attributes));
		if (is_object($val) && get_class($val) == 'soapval' && !$soapval) {
			$this->debug('serialize_val: serialize soapval');
			$xml = $val->serialize($use);
			$this->appendDebug($val->getDebug());
			$val->clearDebug();
			$this->debug('serialize_val of soapval returning ' . $xml);
			return $xml;
		}

		if (is_numeric($name)) {
			$name = '__numeric_' . $name;
		}
		else {
			if (!$name) {
				$name = 'noname';
			}
		}

		$xmlns = '';

		if ($name_ns) {
			$prefix = 'nu' . rand(1000, 9999);
			$name = $prefix . ':' . $name;
			$xmlns .= ' xmlns:' . $prefix . '="' . $name_ns . '"';
		}

		if ($type_ns != '' && $type_ns == $this->namespaces['xsd']) {
			$type_prefix = 'xsd';
		}
		else {
			if ($type_ns) {
				$type_prefix = 'ns' . rand(1000, 9999);
				$xmlns .= ' xmlns:' . $type_prefix . '="' . $type_ns . '"';
			}
		}

		$atts = '';

		if ($attributes) {
			foreach ($attributes as $k => $v) {
				$atts .= ' ' . $k . '="' . $this->expandEntities($v) . '"';
			}
		}

		if (is_null($val)) {
			$this->debug('serialize_val: serialize null');

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '/>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			$xml = '<' . $name . $xmlns . $type_str . $atts . ' xsi:nil="true"/>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		if ($type != '' && isset($this->typemap[$this->XMLSchemaVersion][$type])) {
			$this->debug('serialize_val: serialize xsd built-in primitive type');

			if (is_bool($val)) {
				if ($type == 'boolean') {
					$val = $val ? 'true' : 'false';
				}
				else {
					if (!$val) {
						$val = 0;
					}
				}
			}
			else {
				if (is_string($val)) {
					$val = $this->expandEntities($val);
				}
			}

			if ($use == 'literal') {
				$xml = '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
				$this->debug('serialize_val returning ' . $xml);
				return $xml;
			}

			$xml = '<' . $name . $xmlns . ' xsi:type="xsd:' . $type . '"' . $atts . '>' . $val . '</' . $name . '>';
			$this->debug('serialize_val returning ' . $xml);
			return $xml;
		}

		$xml = '';
		switch (true) {
		case is_bool($val) || $type == 'boolean':
			$this->debug('serialize_val: serialize boolean');

			if ($type == 'boolean') {
				$val = $val ? 'true' : 'false';
			}
			else {
				if (!$val) {
					$val = 0;
				}
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:boolean"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_int($val) || is_long($val) || $type == 'int':
			$this->debug('serialize_val: serialize int');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:int"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_float($val) || is_double($val) || $type == 'float':
			$this->debug('serialize_val: serialize float');

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:float"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_string($val) || $type == 'string':
			$this->debug('serialize_val: serialize string');
			$val = $this->expandEntities($val);

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $val . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . ' xsi:type="xsd:string"' . $atts . '>' . $val . '</' . $name . '>';
			}

			break;

		case is_object($val):
			$this->debug('serialize_val: serialize object');

			if (get_class($val) == 'soapval') {
				$this->debug('serialize_val: serialize soapval object');
				$pXml = $val->serialize($use);
				$this->appendDebug($val->getDebug());
				$val->clearDebug();
			}
			else {
				if (!$name) {
					$name = get_class($val);
					$this->debug('In serialize_val, used class name ' . $name . ' as element name');
				}
				else {
					$this->debug('In serialize_val, do not override name ' . $name . ' for element name for class ' . get_class($val));
				}

				foreach (get_object_vars($val) as $k => $v) {
					$pXml = isset($pXml) ? $pXml . $this->serialize_val($v, $k, false, false, false, false, $use) : $this->serialize_val($v, $k, false, false, false, false, $use);
				}
			}

			if (isset($type) && isset($type_prefix)) {
				$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
			}
			else {
				$type_str = '';
			}

			if ($use == 'literal') {
				$xml .= '<' . $name . $xmlns . $atts . '>' . $pXml . '</' . $name . '>';
			}
			else {
				$xml .= '<' . $name . $xmlns . $type_str . $atts . '>' . $pXml . '</' . $name . '>';
			}

			break;

		case is_array($val) || $type:
			$valueType = $this->isArraySimpleOrStruct($val);
			if ($valueType == 'arraySimple' || preg_match('/^ArrayOf/', $type)) {
				$this->debug('serialize_val: serialize array');
				$i = 0;
				if (is_array($val) && 0 < count($val)) {
					foreach ($val as $v) {
						if (is_object($v) && get_class($v) == 'soapval') {
							$tt_ns = $v->type_ns;
							$tt = $v->type;
						}
						else if (is_array($v)) {
							$tt = $this->isArraySimpleOrStruct($v);
						}
						else {
							$tt = gettype($v);
						}

						$array_types[$tt] = 1;
						$xml .= $this->serialize_val($v, 'item', false, false, false, false, $use);
						++$i;
					}

					if (1 < count($array_types)) {
						$array_typename = 'xsd:anyType';
					}
					else {
						if (isset($tt) && isset($this->typemap[$this->XMLSchemaVersion][$tt])) {
							if ($tt == 'integer') {
								$tt = 'int';
							}

							$array_typename = 'xsd:' . $tt;
						}
						else {
							if (isset($tt) && $tt == 'arraySimple') {
								$array_typename = 'SOAP-ENC:Array';
							}
							else {
								if (isset($tt) && $tt == 'arrayStruct') {
									$array_typename = 'unnamed_struct_use_soapval';
								}
								else {
									if ($tt_ns != '' && $tt_ns == $this->namespaces['xsd']) {
										$array_typename = 'xsd:' . $tt;
									}
									else if ($tt_ns) {
										$tt_prefix = 'ns' . rand(1000, 9999);
										$array_typename = $tt_prefix . ':' . $tt;
										$xmlns .= ' xmlns:' . $tt_prefix . '="' . $tt_ns . '"';
									}
									else {
										$array_typename = $tt;
									}
								}
							}
						}
					}

					$array_type = $i;

					if ($use == 'literal') {
						$type_str = '';
					}
					else {
						if (isset($type) && isset($type_prefix)) {
							$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
						}
						else {
							$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="' . $array_typename . ('[' . $array_type . ']"');
						}
					}
				}
				else if ($use == 'literal') {
					$type_str = '';
				}
				else {
					if (isset($type) && isset($type_prefix)) {
						$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
					}
					else {
						$type_str = ' xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType="xsd:anyType[0]"';
					}
				}

				$xml = '<' . $name . $xmlns . $type_str . $atts . '>' . $xml . ('</' . $name . '>');
			}
			else {
				$this->debug('serialize_val: serialize struct');
				if (isset($type) && isset($type_prefix)) {
					$type_str = ' xsi:type="' . $type_prefix . ':' . $type . '"';
				}
				else {
					$type_str = '';
				}

				if ($use == 'literal') {
					$xml .= '<' . $name . $xmlns . $atts . '>';
				}
				else {
					$xml .= '<' . $name . $xmlns . $type_str . $atts . '>';
				}

				foreach ($val as $k => $v) {
					if ($type == 'Map' && $type_ns == 'http://xml.apache.org/xml-soap') {
						$xml .= '<item>';
						$xml .= $this->serialize_val($k, 'key', false, false, false, false, $use);
						$xml .= $this->serialize_val($v, 'value', false, false, false, false, $use);
						$xml .= '</item>';
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$xml .= '</' . $name . '>';
			}

			break;

		default:
			$this->debug('serialize_val: serialize unknown');
			$xml .= 'not detected, got ' . gettype($val) . ' for ' . $val;
			break;
		}

		$this->debug('serialize_val returning ' . $xml);
		return $xml;
	}

	/**
    * serializes a message
    *
    * @param string $body the XML of the SOAP body
    * @param mixed $headers optional string of XML with SOAP header content, or array of soapval objects for SOAP headers, or associative array
    * @param array $namespaces optional the namespaces used in generating the body and headers
    * @param string $style optional (rpc|document)
    * @param string $use optional (encoded|literal)
    * @param string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
    * @return string the message
    * @access public
    */
	public function serializeEnvelope($body, $headers = false, $namespaces = array(), $style = 'rpc', $use = 'encoded', $encodingStyle = 'http://schemas.xmlsoap.org/soap/encoding/')
	{
		$this->debug('In serializeEnvelope length=' . strlen($body) . ' body (max 1000 characters)=' . substr($body, 0, 1000) . (' style=' . $style . ' use=' . $use . ' encodingStyle=' . $encodingStyle));
		$this->debug('headers:');
		$this->appendDebug($this->varDump($headers));
		$this->debug('namespaces:');
		$this->appendDebug($this->varDump($namespaces));
		$ns_string = '';

		foreach (array_merge($this->namespaces, $namespaces) as $k => $v) {
			$ns_string .= ' xmlns:' . $k . '="' . $v . '"';
		}

		if ($encodingStyle) {
			$ns_string = ' SOAP-ENV:encodingStyle="' . $encodingStyle . '"' . $ns_string;
		}

		if ($headers) {
			if (is_array($headers)) {
				$xml = '';

				foreach ($headers as $k => $v) {
					if (is_object($v) && get_class($v) == 'soapval') {
						$xml .= $this->serialize_val($v, false, false, false, false, false, $use);
					}
					else {
						$xml .= $this->serialize_val($v, $k, false, false, false, false, $use);
					}
				}

				$headers = $xml;
				$this->debug('In serializeEnvelope, serialized array of headers to ' . $headers);
			}

			$headers = '<SOAP-ENV:Header>' . $headers . '</SOAP-ENV:Header>';
		}

		return '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?' . '>' . '<SOAP-ENV:Envelope' . $ns_string . '>' . $headers . '<SOAP-ENV:Body>' . $body . '</SOAP-ENV:Body>' . '</SOAP-ENV:Envelope>';
	}

	/**
	 * formats a string to be inserted into an HTML stream
	 *
	 * @param string $str The string to format
	 * @return string The formatted string
	 * @access public
	 * @deprecated
	 */
	public function formatDump($str)
	{
		$str = htmlspecialchars($str);
		return nl2br($str);
	}

	/**
	* contracts (changes namespace to prefix) a qualified name
	*
	* @param    string $qname qname
	* @return	string contracted qname
	* @access   private
	*/
	public function contractQname($qname)
	{
		if (strrpos($qname, ':')) {
			$name = substr($qname, strrpos($qname, ':') + 1);
			$ns = substr($qname, 0, strrpos($qname, ':'));
			$p = $this->getPrefixFromNamespace($ns);

			if ($p) {
				return $p . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
	* expands (changes prefix to namespace) a qualified name
	*
	* @param    string $qname qname
	* @return	string expanded qname
	* @access   private
	*/
	public function expandQname($qname)
	{
		if (strpos($qname, ':') && !preg_match('/^http:\\/\\//', $qname)) {
			$name = substr(strstr($qname, ':'), 1);
			$prefix = substr($qname, 0, strpos($qname, ':'));

			if (isset($this->namespaces[$prefix])) {
				return $this->namespaces[$prefix] . ':' . $name;
			}

			return $qname;
		}

		return $qname;
	}

	/**
    * returns the local part of a prefixed string
    * returns the original string, if not prefixed
    *
    * @param string $str The prefixed string
    * @return string The local part
    * @access public
    */
	public function getLocalPart($str)
	{
		if ($sstr = strrchr($str, ':')) {
			return substr($sstr, 1);
		}

		return $str;
	}

	/**
    * returns the prefix part of a prefixed string
    * returns false, if not prefixed
    *
    * @param string $str The prefixed string
    * @return mixed The prefix or false if there is no prefix
    * @access public
    */
	public function getPrefix($str)
	{
		if ($pos = strrpos($str, ':')) {
			return substr($str, 0, $pos);
		}

		return false;
	}

	/**
    * pass it a prefix, it returns a namespace
    *
    * @param string $prefix The prefix
    * @return mixed The namespace, false if no namespace has the specified prefix
    * @access public
    */
	public function getNamespaceFromPrefix($prefix)
	{
		if (isset($this->namespaces[$prefix])) {
			return $this->namespaces[$prefix];
		}

		return false;
	}

	/**
    * returns the prefix for a given namespace (or prefix)
    * or false if no prefixes registered for the given namespace
    *
    * @param string $ns The namespace
    * @return mixed The prefix, false if the namespace has no prefixes
    * @access public
    */
	public function getPrefixFromNamespace($ns)
	{
		foreach ($this->namespaces as $p => $n) {
			if ($ns == $n || $ns == $p) {
				$this->usedNamespaces[$p] = $n;
				return $p;
			}
		}

		return false;
	}

	/**
    * returns the time in ODBC canonical form with microseconds
    *
    * @return string The time in ODBC canonical form with microseconds
    * @access public
    */
	public function getmicrotime()
	{
		if (function_exists('gettimeofday')) {
			$tod = gettimeofday();
			$sec = $tod['sec'];
			$usec = $tod['usec'];
		}
		else {
			$sec = time();
			$usec = 0;
		}

		return strftime('%Y-%m-%d %H:%M:%S', $sec) . '.' . sprintf('%06d', $usec);
	}

	/**
	 * Returns a string with the output of var_dump
	 *
	 * @param mixed $data The variable to var_dump
	 * @return string The output of var_dump
	 * @access public
	 */
	public function varDump($data)
	{
		ob_start();
		var_dump($data);
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	/**
	* represents the object as a string
	*
	* @return	string
	* @access   public
	*/
	public function __toString()
	{
		return $this->varDump($this);
	}
}

function timestamp_to_iso8601($timestamp, $utc = true)
{
	$datestr = date('Y-m-d\\TH:i:sO', $timestamp);
	$pos = strrpos($datestr, '+');

	if ($pos === false) {
		$pos = strrpos($datestr, '-');
	}

	if ($pos !== false) {
		if (strlen($datestr) == $pos + 5) {
			$datestr = substr($datestr, 0, $pos + 3) . ':' . substr($datestr, -2);
		}
	}

	if ($utc) {
		$pattern = '/' . '([0-9]{4})-' . '([0-9]{2})-' . '([0-9]{2})' . 'T' . '([0-9]{2}):' . '([0-9]{2}):' . '([0-9]{2})(\\.[0-9]*)?' . '(Z|[+\\-][0-9]{2}:?[0-9]{2})?' . '/';

		if (preg_match($pattern, $datestr, $regs)) {
			return sprintf('%04d-%02d-%02dT%02d:%02d:%02dZ', $regs[1], $regs[2], $regs[3], $regs[4], $regs[5], $regs[6]);
		}

		return false;
	}

	return $datestr;
}

function iso8601_to_timestamp($datestr)
{
	$pattern = '/' . '([0-9]{4})-' . '([0-9]{2})-' . '([0-9]{2})' . 'T' . '([0-9]{2}):' . '([0-9]{2}):' . '([0-9]{2})(\\.[0-9]+)?' . '(Z|[+\\-][0-9]{2}:?[0-9]{2})?' . '/';

	if (preg_match($pattern, $datestr, $regs)) {
		if ($regs[8] != 'Z') {
			$op = substr($regs[8], 0, 1);
			$h = substr($regs[8], 1, 2);
			$m = substr($regs[8], strlen($regs[8]) - 2, 2);

			if ($op == '-') {
				$regs[4] = $regs[4] + $h;
				$regs[5] = $regs[5] + $m;
			}
			else {
				if ($op == '+') {
					$regs[4] = $regs[4] - $h;
					$regs[5] = $regs[5] - $m;
				}
			}
		}

		return gmmktime($regs[4], $regs[5], $regs[6], $regs[2], $regs[3], $regs[1]);
	}

	return false;
}

function usleepWindows($usec)
{
	$start = gettimeofday();

	do {
		$stop = gettimeofday();
		$timePassed = 1000000 * ($stop['sec'] - $start['sec']) + $stop['usec'] - $start['usec'];
	} while ($timePassed < $usec);
}

$GLOBALS['_transient']['static']['nusoap_base']['globalDebugLevel'] = 9;

if (!extension_loaded('soap')) {
	class soapclient extends nusoap_client
	{	}
}

?>
