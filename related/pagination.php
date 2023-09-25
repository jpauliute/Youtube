<?php
class Pagination
{
    public $videos;
    public $pages;
    function __construct($videos, $max)
    {
        $this->videos = $videos;
        $this->pages = ceil($videos / $max);
    }

    public function display($cssClasses = '')
    {
        global $s, $category, $page;

        $pages = (int) $this->pages;

        if($pages === 1) return;

        $pagesHtml = '';
        $previousButton = '';
        $nextButton = '';

        for ($i = 1; $i <= $this->pages; $i++) {
            $isActive = $i === $page ? 'active' : '';

            if ($page + 3 > $i and $page - 3 < $i or $i === 1 or $i === $pages) {
                $pagesHtml .= '<li class="page-item"><a class="page-link ' . $isActive . '" href="?s=' . $s . '&category=' . $category . '&page=' . $i . '">' . $i . '</a></li>';
            }

            if (($page > 4 and $i === 2) or ($page < $pages - 3 and $pages - 1 === $i)) {
                $pagesHtml .= '<li class="page-item"><a class="page-link" href="javascript:void(0)">...</a></li>';
            }

            if($page === 1) {
                $previousButton = 'disabled';
            }

            if($page === $pages) {
                $nextButton = 'disabled';
            }
        }

        return '
        <div class="w-100 d-flex justify-content-center '.$cssClasses.'">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link '.$previousButton.'" href="?s=' . $s . '&category=' . $category . '&page=' . $page - 1 . '" aria-label="Previous">
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    ' . $pagesHtml . '
                    <li class="page-item '.$nextButton.'">
                        <a class="page-link" href="?s=' . $s . '&category=' . $category . '&page=' . $page + 1 . '" aria-label="Next">
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        ';
    }
}

?>