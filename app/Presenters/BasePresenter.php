<?php namespace SisMid\Presenters;

use Laracasts\Presenter\Presenter;

class BasePresenter extends Presenter
{
    /**
     * Return a formated date created_at
     * @return mixed
     */
    public function createdAt()
    {
        return $this->created_at->format("d - M - Y");
    }

    /**
     * Return a formated date updated_at
     * @return mixed
     */
    public function updatedAt()
    {
        return $this->updated_at->format("d - M - Y");
    }
}