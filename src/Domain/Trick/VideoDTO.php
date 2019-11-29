<?php

namespace App\Domain\Trick;

use Symfony\Component\Validator\Constraints as Assert;

final class VideoDTO
{

	/**
	 * @var integer
	 */
	protected $id;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Le lien de la vidéo ne doit pas être vide !"
     * )
     * @Assert\Url(
     *     message="Le lien de la vidéo doit être une URL !"
     * )
     */
    protected $link;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	public function setId(int $id): self
	{
		$this->id = $id;

		return $this;
	}

    /**
     * @return string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }
}
