<?php
//Author: de77.com
//Homepage: http://de77.com
//Version: 22.01.2010
//Licence: MIT

class Youtube
{
	private $videoId;
	
	public function load($url)
	{
		$findme = 'youtube.com/watch?v=';
		
		$pos = strpos($url, $findme);		
		if ($pos === false)
		{
			$this->error = 'Not a valid link';
			return false;
		}
		$pos += strlen($findme);
		
		$pos2 = strpos($url, '&', $pos);
		if ($pos2 === false)
		{
			$pos2 = strlen($url);
		}
		
		$this->videoId = substr($url, $pos, $pos2 - $pos);
		return $this;
	}

	public function loadFromEmbed($url)
	{
		$findme = 'youtube.com/v/';
		
		$pos = strpos($url, $findme);		
		if ($pos === false)
		{
			$this->error = 'Not a valid link';
			return false;
		}
		$pos += strlen($findme);
		
		$pos2 = strpos($url, '&', $pos);
		if ($pos2 === false)
		{
			$pos2 = strpos($url, '"', $pos);
			if ($pos2 === false)
			{
				$pos2 = strlen($url);
			}
		}
		
		$this->videoId = substr($url, $pos, $pos2 - $pos);
		return $this;	
	}
	
	private function hasVideoId()
	{
		if (!isset($this->videoId))
		{
			$this->error = 'Load video first';
			return false;
		}
		return true;		
	}
		
	public function getEmbed($html = false, $width = 425, $height = 344)
	{
		if (!$this->hasVideoId())
		{
			return false;
		}
		
		$link = 'http://www.youtube.com/v/' . $this->videoId;
		if (!$html)
		{
			return $link;
		}
		
		return	'<object width="' . $width . '" height="' . $height . '">' .
				'<param name="movie" value="' . $link . '"></param>' .
				'<param name="allowFullScreen" value="true"></param>' .
				'<param name="allowscriptaccess" value="always"></param>' .
				'<embed src="' . $link . '" type="application/x-shockwave-flash" '.
				'allowscriptaccess="always" allowfullscreen="true" ' .
				'width="' . $width . '" height="' . $height . '"></embed></object>';
	}
	
	public function getPhoto()
	{
		if (!$this->hasVideoId())
		{
			return false;
		}
		
		return 'http://i1.ytimg.com/vi/' . $this->videoId . '/0.jpg';
	}
	
	public function getThumbnail($num = 0)
	{
		if (!$this->hasVideoId())
		{
			return false;
		}
		
		if ($num < 1) $num = 'default';
		if ($num > 3) $num = 3;
		return 'http://i1.ytimg.com/vi/' . $this->videoId . '/' . $num . '.jpg';
	}
	
	public function getThumbnails()
	{
		if (!$this->hasVideoId())
		{
			return false;
		}
		
		$result = array();
		for ($i=0; $i<4; $i++)
		{
			$result[] = $this->getThumbnail($i);
		}
		return $result;
	}
}