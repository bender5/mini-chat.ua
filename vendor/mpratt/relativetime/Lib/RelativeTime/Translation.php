<?php

namespace RelativeTime;

class Translation
{
    protected $config = array();

    public function __construct(array $config = array())
    {
        $this->config = array_merge(array(
            'language' => '\RelativeTime\Languages\English',
            'separator' => ', ',
            'suffix' => true,
        ), $config);
    }

    public function translate(array $units = array(), $direction = 0)
    {
        $lang = $this->loadLanguage();
        if (empty($units))
            return $lang['now'];

        $translation = array();
        foreach ($units as $unit => $v)
        {
            if ($v == 1)
                $translation[] = sprintf($lang[$unit]['singular'], $v);
            else
                $translation[] = sprintf($lang[$unit]['plural'], $v);
        }

        $string = implode($this->config['separator'], $translation);
        if (!$this->config['suffix'])
            return $string;
        else if ($direction > 0)
            return sprintf($lang['ago'], $string);

        return sprintf($lang['left'], $string);
    }

    protected function LoadLanguage()
    {
        $languages = array(
            '\RelativeTime\Languages\\' . $this->config['language'],
            $this->config['language'],
        );

        foreach ($languages as $lang)
        {
            if (class_exists($lang))
                return new $lang();
        }

        return new \RelativeTime\Languages\English();
    }
}
?>
