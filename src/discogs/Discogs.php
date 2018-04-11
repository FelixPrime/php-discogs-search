<?php

namespace discogs;

use discogs\lib\RequestFactory;

class Discogs
{
    /**
    * The Release resource represents a particular physical or digital object
    * released by one or more Artists.
    * @param int $id (req) - Release ID
    * @return array
    */
    public function getRelease($id)
    {
        $request = RequestFactory::build('release', ['release_id' => $id]);
        $data = $request->exec();
        return $data;
    }

    /**
    * The Master resource represents a set of similar Releases.
    * Masters (also known as “master releases”) have a “main release” which is
    * often the chronologically earliest.
    * @param int $id (req) - Master ID
    * @return array
    */
    public function getMasterRelease($id)
    {
        $request = RequestFactory::build('masterRelease', ['master_id' => $id]);
        $data = $request->exec();
        return $data;
    }

    /**
    * Retrieves a list of all Releases that are versions of this master.
    * @param int $id (req) - Master ID
    * @param int $page (opt) - Page
    * @param int $perPage (opt) -  Items per page (up to 100)
    * @return array
    */
    public function getMasterReleaseVersions($id, $page = 1, $perPage = 50)
    {
        $params = ['master_id' => $id];
        if (is_numeric($page) && $page > 1) {
            $params['page'] = $page;
        }
        if (is_numeric($perPage) && $perPage != 50) {
            $params['perPage'] = $perPage;
        }

        $request = RequestFactory::build('masterReleaseVersions', $params);
        $data = $request->exec();
        return $data;
    }

    /**
     * The Artist resource represents a person in the Discogs database who
     * contributed to a Release in some capacity.
     * @param int $id (req) - Artist ID
     * @return array
     */
    public function getArtist($id)
    {
        $request = RequestFactory::build('artist', ['artist_id' => $id]);
        $data = $request->exec();
        return $data;
    }

    /**
    * Returns a list of Releases and Masters associated with the Artist.
    * @param int $id (req) - Artist ID
    * @param int $page (opt) - Page
    * @param int $perPage (opt) -  Items per page (up to 100)
    * @param string $sort (opt) - Sort items by: year, title, format
    * @param string $sortOrder (opt) - Sort items in a particular order (one of asc, desc)
    * @return array
    */
    public function getArtistReleases($id, $page = 1, $perPage = 50, $sort = '', $sortOrder = '')
    {
        $params = ['artis_id' => $id];
        if (is_numeric($page) && $page > 1) {
            $params['page'] = $page;
        }
        if (is_numeric($perPage) && $perPage != 50) {
            $params['perPage'] = $perPage;
        }
        if (!empty($sort) && in_array($sort, ['year', 'title', 'format'])) {
            $params['sort'] = $sort;
        }
        if (!empty($sortOrder) && in_array($sort, ['asc', 'desc'])) {
            $params['sortOrder'] = $sortOrder;
        }

        $request = RequestFactory::build('artistReleases', $params);
        $data = $request->exec();
        return $data;
    }

    /**
     * The Label resource represents a label, company, recording studio, location,
     * or other entity involved with Artists and Releases.
     * @param int $id (req) - Label ID
     * @return array
     */
    public function getLabel($id)
    {
        $request = RequestFactory::build('label', ['label_id' => $id]);
        $data = $request->exec();
        return $data;
    }

    /**
    * Returns a list of Releases associated with the label.
    * @param int $id (req) - Label ID
    * @param int $page (opt) - Page
    * @param int $perPage (opt) -  Items per page (up to 100)
    * @return array
    */
    public function getAllLabelReleases($id, $page = 1, $perPage = 50)
    {
        $params = ['label_id' => $id];
        if (is_numeric($page) && $page > 1) {
            $params['page'] = $page;
        }
        if (is_numeric($perPage) && $perPage != 50) {
            $params['perPage'] = $perPage;
        }

        $request = RequestFactory::build('allLabelReleases', $params);
        $data = $request->exec();
        return $data;
    }

    /**
    * Issue a search query to Discogs database.
    * @link https://www.discogs.com/developers/#page:database,header:database-search
    * @param int $token (req) - Authentication (as any user) is required
    * @param array $searchParams (opt)
    * <ul>
    *   <li><b>q</b> string (optional) - Your search query</li>
    *   <li><b>type</b> string (optional) - One of release, master, artist, label</li>
    *   <li><b>title</b> string (optional) - Search by combined “Artist Name - Release Title” title field</li>
    *   <li><b>release_title</b> string (optional) - Search release titles</li>
    *   <li><b>credit</b> string (optional) - Search release credits</li>
    *   <li><b>artist</b> string (optional) - Search artist names</li>
    *   <li><b>anv</b> string (optional) - Search artist ANV</li>
    *   <li><b>label</b> string (optional) - Search label names</li>
    *   <li><b>genre</b> string (optional) - Search genres</li>
    *   <li><b>style</b> string (optional) - Search styles</li>
    *   <li><b>country</b> string (optional) - Search release country</li>
    *   <li><b>year</b> string (optional) - Search release year</li>
    *   <li><b>format</b> string (optional) - Search formats</li>
    *   <li><b>catno</b> string (optional) - Search catalog number</li>
    *   <li><b>barcode</b> string (optional) - Search barcodes</li>
    *   <li><b>track</b> string (optional) - Search track titles</li>
    *   <li><b>submitter</b> string (optional) - Search submitter username</li>
    *   <li><b>contributor</b> string (optional) - Search contributor usernames</li>
    * </ul>
    * @param int $page (opt) - Page
    * @param int $perPage (opt) -  Items per page (up to 100)
    * @return array
    */
    public function search($token, $searchParams = [], $page = 1, $perPage = 50)
    {
        $params = ['token' => $token];
        if (is_numeric($page) && $page > 1) {
            $params['page'] = $page;
        }
        if (is_numeric($perPage) && $perPage != 50) {
            $params['perPage'] = $perPage;
        }

        $params = array_merge($params, $searchParams);

        $request = RequestFactory::build('search', $params);
        $data = $request->exec();
        return $data;
    }
}
