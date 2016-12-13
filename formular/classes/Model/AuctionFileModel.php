<?php

namespace Model;


class AuctionFileModel
{
    public function getAllFiles($auctionId, $uname = '')
    {
        $res = array();
        $res['adminFile'] = $this->getAdminFile($auctionId);
        $res['userFiles'] = $this->getUserFiles($auctionId, $uname);
        return $res;
    }

    private function getAdminFile($auctionId)
    {
        $dir = PROJECT_ROOT . '\\auction_files\\' . $auctionId . '\\admin';
        $files = scandir($dir);
        $dir .= '\\';
        foreach ($files as $file) {
            if (is_file($dir . $file)) {
                return $dir . $file;
            }
        }
        return null;
    }

    private function getUserFiles($auctionId, $uname)
    {
        $res = array();
        $dir = PROJECT_ROOT . '\\auction_files\\' . $auctionId . '\\userFiles';
        $files = scandir($dir);
        $dir .= '\\';
        if ($uname == '') {
            foreach ($files as $file) {
                if (is_file($dir . $file)) {
                    $res[] = $dir . $file;
                }
            }
        }else{
            foreach ($files as $file) {
                if (is_file($dir . $file) && pathinfo($dir.$file)['filename'] == $uname) {
                    $res[] = $dir . $file;
                }
            }
        }
        return $res;
    }
}