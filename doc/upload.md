# Upload de fichier

## Champ File

Pour gérer facilement l'upload de fichier, Sf posséde une classe UploadedFile, l'ajout d'une contrainte ``Image`` ou ``File`` permet d'indiquer le type de champ de formulaire.

```php 

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class File 
{
    #[Assert\Image(maxSize: '3M')]
    private UploadedFile $file;
```

## Evénements Doctrine

L'upload de fichier peut se faire automatiquement après avoir insérer les données dans la base de données grâce aux événements Doctrine:

![DoctrineEvents](./img/doctrine%20events.jpg)

Nous pouvons ainsi écrire des méthodes qui seront appelées automatiquement par Doctrine avant ou après un persist par exemple.

Ajouter cette ligne pour indiquer à Doctrine que cette entité contient des événements:

```php 

use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
class File
{
```

```php 
    #[ORM\PostPersist]
    #[ORM\PostUpdate]
    public function upload(): void 
    {
        if ($this->file instanceof UploadedFile) {
            $this->file->move(self::getPublicRootDir(), $this->path);
        }
    }
```