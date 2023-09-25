<?php
class AddVideoAction
{
    public static function init()
    {
        if (isValidPost(['vid', 'name', 'description', 'category'])) {
            $vid = $_POST['vid'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $category = $_POST['category'];

            if (strlen($vid) !== 11) {
                $err = "Wrong video ID length. It should be 11 characters";
            } elseif (self::isValidLength($name, 2, 100)) {
                $err = "Wrong name length. It should contain between 2 and 100 characters.";
            } elseif (self::isValidLength($description, 2, 1000)) {
                $err = "Wrong description length. It should contain between 2 and 1000 characters.";
            } elseif (self::videoExists($vid)) {
                $err = "Video with this ID is already in our system.";
            } elseif(self::videosExceeds()) {
                $err = "You can add maximum of 100 videos.";
            } else {
                self::saveVideo($vid, $name, $description, $category);

                $success = "Video was added to our system.";
            }

            return [isset($err) ? $err : '', isset($success) ? $success : ''];
        }
    }

    private static function isValidLength(string $string, int $minimum, int $maximum): bool
    {
        $l = strlen($string);

        return $l < $minimum OR $l > $maximum;
    }

    private static function videoExists(string $vid): bool
    {
        return S::countObjects('videos', 'vid=:vid', [':vid' => $vid]);
    }

    private static function videosExceeds() {
        global $data;

        $countVideos = S::countObjects('videos', 'uid=:uid', [':uid' => $data['id']]);
        
        return $countVideos > 100;
    }

    private static function saveVideo(string $vid, string $name, string $description, int $category): void
    {
        global $data;

        S::insert(
            'videos',
            'vid, name, description, category, uid',
            ':vid, :name, :description, :category, :uid',
            [
                ':vid' => $vid,
                ':name' => $name,
                ':description' => $description,
                ':category' => $category,
                ':uid' => $data['id']
            ]
        );
    }
}

?>