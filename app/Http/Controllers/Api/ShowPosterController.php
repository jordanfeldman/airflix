<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use Airflix\Contracts\Shows;
use Airflix\Contracts\ShowImages;

class ShowPosterController extends ApiController
{
    /**
     * Inject the tv shows resource.
     *
     * @return \Airflix\Contracts\Shows
     */
    protected function shows()
    {
        return app()->make(Shows::class);
    }

    /**
     * Inject the tv show images resource.
     *
     * @return \Airflix\Contracts\ShowImages
     */
    protected function showImages()
    {
        return app()->make(ShowImages::class);
    }

    /**
     * Get a collection of tv show posters from the tmdb API.
     *
     * @param  string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = $this->shows()
            ->get($id);

        $posters = $this->showImages()
            ->getPosters($show);

        $transformer = $this->showImages()
            ->transformer();

        return $this->apiResponse()
            ->respondWithCollection(
                $posters, 
                $transformer
            );
    }
}
