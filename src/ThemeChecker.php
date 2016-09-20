<?php
namespace WPChecksum;

class ThemeChecker extends BaseChecker
{

    public function __construct($localCache = false)
    {
        $this->basePath = get_theme_root();
        $this->localCache = $localCache;

        parent::__construct();
    }

    public function check($slug, $theme)
    {
        $ret = array();
        $ret['type'] = 'theme';
        $ret['slug'] = $slug;
        $ret['version'] = $theme['Version'];

        $original = $this->getOriginalChecksums('theme', $slug, $theme['Version']);
        if ($original) {
            $local = $this->getLocalChecksums($this->basePath . "/$slug");
            $changeSet = $this->getChangeSet($original, $local);
            $ret['status'] = 'checked';
            $ret['message'] = '';
            $ret['changeset'] = $changeSet;
        } else {
            $ret['status'] =  'unchecked';
            $ret['message'] = 'Theme original not found';
            $ret['changeset'] = array();
        }

        return $ret;
    }
}