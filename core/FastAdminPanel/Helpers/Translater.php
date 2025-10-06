<?php

namespace App\FastAdminPanel\Helpers;

// legacy
class Translater
{
    protected $tags = [];

    protected $attempts;

    protected $tagsMask = [
        ' ☀ ', ' 👆 ', ' ☁ ', ' 👇 ', ' ☂ ', ' 👈 ', ' ✊ ', ' 👉 ', ' ✋ ', ' 👊 ', ' 👋 ', ' 👌 ', ' ☏ ', ' ☐ ', ' ☑ ', ' ☒ ', ' ☓ ', ' ☔ ', ' ☕ ', ' ☖ ', ' ☗ ', ' ☘ ', ' ☙ ', ' ☚ ', ' 🙈 ', ' 🙉 ', ' 🙊 ', ' 🙋 ', ' 🙌 ', ' 🙍 ', ' 🙎 ', ' 🐲 ', ' 👀 ', ' 🐝 ', ' 💢 ', ' ☘ ', ' ✌ ', ' ∞ ', ' 🐾 ', ' 💋 ', ' 👣 ', ' 🚗 ', ' ☠ ', ' 🚀 ', ' 🚃 ', ' 🚄 ', ' 🚅 ', ' 🚇 ', ' 🚉 ', ' 🚌 ', ' 🚏 ', ' 🚑 ', ' 🚒 ', ' 🚓 ', ' 🚕 ', ' 😄 ', ' 😅 ', ' 🚙 ', ' 🚚 ', ' 🚢 ', ' 😁 ', ' 😂 ', ' 😃 ', ' 😆 ', ' 😇 ', ' 😈 ', ' 😉 ', ' 😊 ', ' 😋 ', ' 😌 ', ' 😍 ', ' 😎 ', ' 😏 ', ' 😐 ', ' 😒 ', ' 🚤 ', ' 😓 ', ' 😔 ', ' 😖 ', ' 😘 ', ' 😚 ', ' 😜 ', ' 😝 ', ' 😞 ', ' 😠 ', ' 😡 ', ' 😢 ', ' 😣 ', ' 😤 ', ' 😥 ', ' 😨 ', ' 😩 ', ' 😪 ', ' 😫 ', ' 😭 ', ' 😰 ', ' 🌏 ', ' 🍀 ', ' 😱 ', ' 😲 ', ' 😳 ', ' 😵 ', ' 😶 ', ' 😷 ', ' 😸 ', ' 😹 ', ' 😺 ', ' 😻 ', ' 😼 ', ' 😽 ', ' 😾 ', ' 😿 ', ' 🙀 ', ' 🙅 ', ' 🙆 ', ' 🙇 ',
    ];

    public function __construct($attempts = 4)
    {
        $this->attempts = $attempts;
    }

    public function tr($content, $languageFrom, $languageTo)
    {
        $content = $this->encodeData($content);

        if (mb_strlen($content) < 4000) {

            $content = $this->translateRequest($content, $languageFrom, $languageTo);

            return $this->decodeData($content);
        }

        $textParts = [];

        while (mb_strlen($content) > 3000) {

            $textPart = mb_substr($content, 0, 3000);

            $partSeparatorPos = mb_strripos($textPart, '.') === false ? mb_strripos($textPart, ' ') : mb_strripos($textPart, '.');

            $textStartPart = mb_substr($textPart, 0, $partSeparatorPos + 1);
            $textParts[] = $textStartPart;

            $content = str_replace($textStartPart, '', $content);
        }

        $textParts[] = $content;

        $result = '';
        foreach ($textParts as $textPart) {
            $result .= $this->translateRequest($textPart, $languageFrom, $languageTo);
        }

        $result = $this->decodeData($result);

        return $result;
    }

    protected function translateRequest($text, $languageFrom, $languageTo)
    {
        usleep(500000);

        $url = 'https://translate.google.com/translate_a/single?client=at&dt=t&dt=ld&dt=qca&dt=rm&dt=bd&dj=1&hl=uk-RU&ie=UTF-8&oe=UTF-8&inputm=2&otf=2&iid=1dd3b944-fa62-4b55-b330-74909a99969e';

        if (mb_strlen($text) >= 5000) {
            throw new \Exception('Maximum number of characters exceeded: 5000');
        }

        $fields = [
            'sl' => urlencode($languageFrom),
            'tl' => urlencode($languageTo),
            'q' => urlencode($text),
        ];

        $fields_string = $this->fieldsToQuery($fields);

        $content = $this->request($url, $fields, $fields_string, 0);

        $translation = $this->getSentencesFromJSON($content);

        return $translation;
    }

    protected function encodeData($text)
    {
        $this->tags = [];

        $tagsCount = count($this->tagsMask);

        preg_match_all('/\<\/?[^\>]+\>/', $text, $matches);

        $allTags = array_unique($matches[0]);

        $i = 0;
        foreach ($allTags as $tag) {

            $text = str_replace($tag, $this->tagsMask[$i], $text);
            $this->tags[] = $tag;
            $i++;

            if ($i > $tagsCount) {

                throw new \Exception('Need more tags mask');
            }
        }

        return $text;
    }

    protected function decodeData($text)
    {
        for ($i = 0, $count = count($this->tags); $i < $count; $i++) {

            $tagMaskBack = str_replace(' ', '', $this->tagsMask[$i]);

            $text = str_replace($tagMaskBack, $this->tags[$i], $text);
        }

        $text = str_replace('  ', ' ', $text);

        return $text;
    }

    protected function request($url, $fields, $fields_string, $i)
    {
        $i++;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_PROXY, Proxy::$ip);
        // curl_setopt($ch, CURLOPT_PROXYUSERPWD, Proxy::$auth);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        // curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_USERAGENT, 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1');

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($result === false || $httpcode !== 200) {

            if ($i >= $this->attempts) {
                throw new \Exception('Could not connect and get data');
            }

            usleep(1500000);

            return $this->request($url, $fields, $fields_string, $i);
        }

        return $result;
    }

    protected function fieldsToQuery($fields)
    {
        $fields_string = '';

        foreach ($fields as $key => $value) {

            $fields_string .= $key.'='.$value.'&';
        }

        return rtrim($fields_string, '&');
    }

    protected function getSentencesFromJSON($json)
    {
        $arr = json_decode($json, true);
        $sentences = '';

        if (isset($arr['sentences'])) {
            foreach ($arr['sentences'] as $s) {
                $sentences .= isset($s['trans']) ? $s['trans'] : '';
            }
        }

        return $sentences;
    }
}
