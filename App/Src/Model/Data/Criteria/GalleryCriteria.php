<?php

namespace App\Src\Model\Data\Criteria;

class GalleryCriteria
{
    protected $offset;

    protected $chunk;

    public static function create(): GalleryCriteria
    {
        return new self();
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return GalleryCriteria
     */
    public function setOffset(int $offset): GalleryCriteria
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @return int
     */
    public function getChunk(): int
    {
        return $this->chunk;
    }

    /**
     * @param int $chunk
     * @return GalleryCriteria
     */
    public function setChunk(int $chunk): GalleryCriteria
    {
        $this->chunk = $chunk;
        return $this;
    }
}
