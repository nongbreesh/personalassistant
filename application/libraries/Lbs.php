<?php
 
/**
 * Written by Amri Shodiq.
 * Do not hesitate to copy and paste this code. 
 * It's not embarassing.
 */
 
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');
class Lbs {
	public function getCompleteAddress($lac, $cid) {
		$latLng = $this->getLatLong($lac, $cid);
		if (is_array($latLng)) {
			$data = $this->getAddress($latLng["lat"], $latLng["lng"]);
 
//			$address = $data["meta"]["message"];
			$address = $data["response"]["address"];
			$meta = array(
				"status"=>200,
				"message"=>"Succeed."
			);
			$response = array(
				"lat"=>$latLng["lat"],
				"lng"=>$latLng["lng"],
				"address"=>$address,
				"city"=>$data["response"]["city"]
			);
			return array(
				"meta"=>$meta,
				"response"=>$response
			);
		} else {
			$meta = array(
				"status"=>406,
				"message"=>"Location is not known."
			);
			return array("meta"=>$meta);
		}
	}
 
	public function reverseAddress($address) {
		$use_curl = false;
		if ($use_curl) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=true");
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, Array (
				"Content-type: application/binary"
			));
			curl_setopt($ch, CURLOPT_POST, 1);
			$response = curl_exec($ch);
			if (curl_errno($ch))
				return -1;
 
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$str = substr($response, $header_size);
 
			curl_close($ch);
 
			$data = json_decode($str, true);
			if (isset($data["results"]) && is_array($data["results"])) {
				$latLong = $data["results"][0]["geometry"]["location"];
				$meta = array(
					"status"=>200,
					"message"=>"Succeed."
				);
				return array("meta"=>$meta, "response"=>$latLong);
			} else {
				$meta = array(
					"status"=>406,
					"message"=>"Address is not known."
				);
				return array("meta"=>$meta);
			}
		} else {
			$str = @file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=true");
			$data = json_decode($str, true);
			if (isset($data["results"]) && is_array($data["results"])) {
				$latLong = $data["results"][0]["geometry"]["location"];
				$meta = array(
					"status"=>200,
					"message"=>"Succeed."
				);
				return array("meta"=>$meta, "response"=>$latLong);
			} else {
				$meta = array(
					"status"=>406,
					"message"=>"Address is not known."
				);
				return array("meta"=>$meta);
			}
		}
	}
 
	private function getContent($url) {
		$str = "";
		$use_curl = false;
		if ($use_curl) {
			$ch = curl_init();
			$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
			curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, Array (
				"Content-type: text/xml"
			));
			$response = curl_exec($ch);
			if (curl_errno($ch))
				return -1;
 
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$str = substr($response, $header_size);
 
			curl_close($ch);
 
			echo "STR CURL: ".$str;
		} else {
			$str = file_get_contents($url, 0);
		}
 
		return $str;
	}
 
	public function getWeather($lac, $cid) {
//		return $this->getContent("http://www.google.com/ig/api?weather=Depok,ID");
 
		$latLng = $this->getLatLong($lac, $cid);
		if (is_array($latLng)) {
			$lat = $latLng["lat"];
			$lng = $latLng["lng"];
 
			$use_curl = false;
			$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . "," . $lng . "&sensor=true";
			$str = "";
			if ($use_curl) {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, Array (
					"Content-type: application/binary"
				));
				curl_setopt($ch, CURLOPT_POST, 1);
				$response = curl_exec($ch);
				if (curl_errno($ch))
					return -1;
 
				$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
				$str = substr($response, $header_size);
 
				curl_close($ch);
			} else {
				$str = @file_get_contents($url);
			}
 
			$data = json_decode($str, true);
			if (isset($data["results"]) && is_array($data["results"])) {
				$ac = $data["results"][0]["address_components"];
				$len = count($ac);
				$i = 0;
				$city = "";
				while ($i<$len) {
					if (in_array("locality", $ac[$i]["types"])) $city = $ac[$i]["long_name"];
					else if (in_array("country", $ac[$i]["types"])) $city .= ",".$ac[$i]["short_name"];
					$i++;
				}
 
//				$city = $data["results"][0]["address_components"][3]["long_name"].",".$data["results"][0]["address_components"][5]["short_name"];
 
				$url = "http://www.google.com/ig/api?weather=".str_replace("\"", "", $city);
 
//				return $url;
//				return $this->getContent($url);
				return $this->getContent("http://www.google.com/ig/api?weather=Depok,ID");
			} else {
				return "false";
			}
 
 
		} else {
			return "false";
		}
 
//		if (isset($data["results"]) && is_array($data["results"])) {
//			$street = $data["results"][0]["formatted_address"];
//			$meta = array(
//				"status"=>200,
//				"message"=>"Succeed."
//			);
//			return array("meta"=>$meta, "response"=>array("address"=>$street));
//		} else {
//			$meta = array(
//				"status"=>406,
//				"message"=>"Address is not known."
//			);
//			return array("meta", $meta);
//		}
	}
 
	public function getAddress($lat, $lng) {
		$use_curl = false;
		if ($use_curl) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . "," . $lng . "&sensor=true");
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, Array (
				"Content-type: application/binary"
			));
			curl_setopt($ch, CURLOPT_POST, 1);
			$response = curl_exec($ch);
			if (curl_errno($ch))
				return -1;
 
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$str = substr($response, $header_size);
 
			curl_close($ch);
 
			$data = json_decode($str, true);
			if (isset($data["results"]) && is_array($data["results"])) {
				$street = $data["results"][0]["formatted_address"];
				$ac = $data["results"][0]["address_components"];
				$len = count($ac);
				$i = 0;
				$city = "";
				while ($i<$len) {
					if (in_array("locality", $ac[$i]["types"])) $city = $ac[$i]["long_name"];
					else if (in_array("country", $ac[$i]["types"])) $city .= ",".$ac[$i]["short_name"];
					$i++;
				}
				$meta = array(
					"status"=>200,
					"message"=>"Succeed."
				);
				return array("meta"=>$meta, "response"=>array("address"=>$street, "city"=>$city));
			} else {
				$meta = array(
					"status"=>406,
					"message"=>"Address is not known."
				);
				return array("meta", $meta);
			}
		} else {
			$str = @file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . "," . $lng . "&sensor=true");
			$data = json_decode($str, true);
			if (isset($data["results"]) && is_array($data["results"])) {
				$street = $data["results"][0]["formatted_address"];
				$ac = $data["results"][0]["address_components"];
				$len = count($ac);
				$i = 0;
				$city = "";
				while ($i<$len) {
					if (in_array("locality", $ac[$i]["types"])) $city = $ac[$i]["long_name"];
					else if (in_array("country", $ac[$i]["types"])) $city .= ",".$ac[$i]["short_name"];
					$i++;
				}
				$meta = array(
					"status"=>200,
					"message"=>"Succeed."
				);
				return array("meta"=>$meta, "response"=>array("address"=>$street, "city"=>$city));
			} else {
				$meta = array(
					"status"=>406,
					"message"=>"Address is not known."
				);
				return array("meta"=>$meta);
			}
		}
	}
 
	public function getLatLong($lac, $cid) {
 
		if (isset ($lac) && isset ($cid)) {
			$CI =& get_instance();
			$CI->load->database();
 
			$data = "\x00\x0e" .
			"\x00\x00\x00\x00\x00\x00\x00\x00" .
			"\x00\x00" .
			"\x00\x00" .
			"\x00\x00" .
			"\x1b" .
			"\x00\x00\x00\x00" .
			"\x00\x00\x00\x00" .
			"\x00\x00\x00\x00" .
			"\x00\x00" .
			"\x00\x00\x00\x00" .
			"\x00\x00\x00\x00" .
			"\x00\x00\x00\x00" .
			"\x00\x00\x00\x00" .
			"\xff\xff\xff\xff" .
			"\x00\x00\x00\x00";
 
			$is_umts_cell = ($cid > 65535);
			if ($is_umts_cell) // GSM: 4 hex digits, UTMS: 6 hex digits
				$data[0x1c] = 5;
			else
				$data[0x1c] = 3;
 
			$hexlac = substr("00000000" . dechex($lac), -8);
			$hexcid = substr("00000000" . dechex($cid), -8);
 
			$data[0x1f] = pack("H*", substr($hexcid, 0, 2));
			$data[0x20] = pack("H*", substr($hexcid, 2, 2));
			$data[0x21] = pack("H*", substr($hexcid, 4, 2));
			$data[0x22] = pack("H*", substr($hexcid, 6, 2));
 
			$data[0x23] = pack("H*", substr($hexlac, 0, 2));
			$data[0x24] = pack("H*", substr($hexlac, 2, 2));
			$data[0x25] = pack("H*", substr($hexlac, 4, 2));
			$data[0x26] = pack("H*", substr($hexlac, 6, 2));
 
			/* I used file_get_contents() at my laptop webserver, but it seems like the PHP version
			 * at my hosting company is old and it is not supporting that.
			 * For the hosting company, here we're using cURL.
			 */
			$use_curl = false;
			if ($use_curl) {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://www.google.com/glm/mmap");
				curl_setopt($ch, CURLOPT_HEADER, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, Array (
					"Content-type: application/binary"
				));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_POST, 1);
				$response = curl_exec($ch);
				if (curl_errno($ch))
					return -1;
 
				$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
				$str = substr($response, $header_size);
 
				curl_close($ch);
			} else {
				$context = array (
					'http' => array (
						'method' => 'POST',
						'header' => "Content-type: application/binary\r\n" . "Content-Length: " . strlen($data
					) . "\r\n",
					'content' => $data
				));
				$xcontext = stream_context_create($context);
				$str = file_get_contents("http://www.google.com/glm/mmap", FALSE, $xcontext);
			}
 
			$opcode1 = ((ord($str[0]) << 8)) | ord($str[1]);
			$opcode2 = ord($str[2]);
 
			if (($opcode1 != 0x0e) || ($opcode2 != 0x1b))
				return -2;
 
			$retcode = ((ord($str[3]) << 24) | (ord($str[4]) << 16) | (ord($str[5]) << 8) | (ord($str[6])));
			if ($retcode != 0)
				return -2;
 
			$lat = ((ord($str[7]) << 24) | (ord($str[8]) << 16) | (ord($str[9]) << 8) | (ord($str[10]))) / 1000000;
			$lon = ((ord($str[11]) << 24) | (ord($str[12]) << 16) | (ord($str[13]) << 8) | (ord($str[14]))) / 1000000;
 
			// exit script if cannot geocode cell e.g. not on google's database
			if ($lat == 0 and $lon == 0)
				return -3;
 
			$data = array(
			   'cellid' => $cid,
			   'lac' => $lac,
			   'lat' => $lat,
			   'lon' => $lon,
			);
 
			//$CI->db->insert('celltower', $data);
 
			return array (
				"lat" => $lat,
				"lng" => $lon
			);
		} else
			return -4;
	}
 
	// Reff: http://code.google.com/intl/id-ID/apis/maps/documentation/directions/
	// http://localhost/rest/index.php/api/location/direction/<origin>/<destination>
	// e.g: http://localhost/rest/index.php/api/location/direction/Sawangan-Depok/Senayan-Jakarta
	public function getDirection($origin, $destination, $travelMode) {
		$use_curl = false;
		if ($use_curl) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://maps.googleapis.com/maps/api/directions/json?origin=".$origin."&destination=".$destination."&mode=".$travelMode."&sensor=false");
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, Array (
				"Content-type: application/binary"
			));
			curl_setopt($ch, CURLOPT_POST, 1);
			$response = curl_exec($ch);
			if (curl_errno($ch))
				return -1;
 
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$str = substr($response, $header_size);
 
			curl_close($ch);
 
			$data = json_decode($str, true);
			if (isset($data["status"]) && $data["status"] == "OK") {
				$meta = array(
					"status"=>200,
					"message"=>"Succeed."
				);
				$res = $data["routes"][0]["legs"][0];
				$startAddress = $res["start_address"];
				$endAddress = $res["end_address"];
				$startLocation = $res["start_location"];
				$endLocation = $res["end_location"];
				$duration = $res["duration"];
				$distance = $res["distance"];
 
				$steps = $res["steps"];
				$len = count($steps);
				$i = 0;
				$row = array();
				while ($i<$len) {
					$text = $steps[$i]["html_instructions"];
					$start = $steps[$i]["start_location"];
					$end = $steps[$i]["end_location"];
					$dist = $steps[$i]["distance"];
					$dur = $steps[$i]["duration"];
					array_push($row, array(
						"text"=>strip_tags($text),
						"start"=>$start,
						"end"=>$end,
						"distance"=>$dist,
						"duration"=>$dur
					));
					$i++;
				}
				return array("meta"=>$meta, "response"=>array(
					"start_address"=>$startAddress,
					"end_address"=>$endAddress,
					"start_location"=>$startLocation,
					"end_location"=>$endLocation,
					"duration"=>$duration,
					"distance"=>$distance,
					"steps"=>$row
				));
			} else {
				$meta = array(
					"status"=>406,
					"message"=>"Direction is not known."
				);
				return array("meta"=>$meta);
			}
		} else {
			$str = @file_get_contents("http://maps.googleapis.com/maps/api/directions/json?origin=".$origin."&destination=".$destination."&mode=".$travelMode."&sensor=false");
			$data = json_decode($str, true);
			if (isset($data["status"]) && $data["status"] == "OK") {
				$meta = array(
					"status"=>200,
					"message"=>"Succeed."
				);
				$res = $data["routes"][0]["legs"][0];
				$startAddress = $res["start_address"];
				$endAddress = $res["end_address"];
				$startLocation = $res["start_location"];
				$endLocation = $res["end_location"];
				$duration = $res["duration"];
				$distance = $res["distance"];
 
				$steps = $res["steps"];
				$len = count($steps);
				$i = 0;
				$row = array();
				while ($i<$len) {
					$text = $steps[$i]["html_instructions"];
					$start = $steps[$i]["start_location"];
					$end = $steps[$i]["end_location"];
					$dist = $steps[$i]["distance"];
					$dur = $steps[$i]["duration"];
					array_push($row, array(
						"text"=>strip_tags($text),
						"start"=>$start,
						"end"=>$end,
						"distance"=>$dist,
						"duration"=>$dur
					));
					$i++;
				}
				return array("meta"=>$meta, "response"=>array(
					"start_address"=>$startAddress,
					"end_address"=>$endAddress,
					"start_location"=>$startLocation,
					"end_location"=>$endLocation,
					"duration"=>$duration,
					"distance"=>$distance,
					"steps"=>$row
				));
			} else {
				$meta = array(
					"status"=>406,
					"message"=>"Direction is not known."
				);
				return array("meta"=>$meta);
			}
		}
	}
 
	// Local search could use Google's local search API (deprecated) or
	// custom search https://code.google.com/intl/id-ID/apis/customsearch/v1/overview.html (100 query per day, shit)
}
 
/* End of file Lbs.php */
