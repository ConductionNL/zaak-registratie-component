# Tutorial

What do you need for this tutorial?
* Browser
* Github account
* Git client
* Docker account
* Docker for desktop

## Before you begin
For the steps consirning the generation of entities an example entity a availale, feel free to [take a look](https://github.com/ConductionNL/Proto-component-commonground/blob/master/api/src/Entity/ExampleEntity.php) at it if you have trouble figuring out the code.

## Setting up your enviroment

You can install docker-desktop from [the docker website](). 


## Generating your component (repository/codebase)
Starting up your first Common Ground component is extremely easy, al you need is a GitHub account and go the link below and fill in the form, press create and press to we have a component!

[https://github.com/ConductionNL/Proto-component-commonground/generate](https://github.com/ConductionNL/Proto-component-commonground/generate) 

After that you should be redirected to your own brand new repository. 

**Oke cool but what did we just do?**
We ran a fork of the base Common Ground component, that means that we copied the code of the original project into a new repository. By doing so we made sure we have all the necessities for our component, including security and compliance with international standards. 

## Spinning up your component
Before we can spin up our component we must first get a local copy from our repository, we can either do this through the command line (example here) or use a Git client. 

For this example where going to use GitKraken but you can use any tool you like, feel free to skip this part if you are already familiar with setting up a local clone of your repository.

Open gitkraken press "clone a repro" and fill in the form (select where on your local machine you want the repository to be stored, and fill in the link of your repository on github), press "clone a repro" and you should then see GitKraken downloading your code. After it's done press "open now" (in the box on top) and voilá your codebase (you should see an initial commit on a master branche).

You can now navigate to the folder where you just installed your code, it should contain some folders and files and generally look like this. We will get into the files later, lets first spin up our component!

Open a command window (example) and browse to the folder where you just stuffed your code, navigating in a command window is done by cd, so for our example we could type 
cd c:\repos\common-ground\my-component (if you installed your code on a different disk then where the cmd window opens first type <diskname>: for example D: and hit enter to go to that disk, D in this case). We are now in our folder, so let's go! Type docker-compose up and hit enter. From now on whenever we describe a command line command we will document it as follows:

```CLI
$ docker-compose up
```

Your computer should now start up your local development environment. Don't worry about al the code coming by, let's just wait until it finishes. You're free to watch along and see what exactly docker is doing, you will know when it's finished when it tells you that it is ready to handle connections. 

Open your browser type http://localhost/ as address and hit enter, you should now see your common ground component up and running.

### trouble shooting
When spinning up components we make extensive use of the cashing of docker, and use volumes to reprecent server disks. When running in to unexpected trouble always remmember to clear your local docker vm with the -a command (removing image cash)
```CLI
$ docker system prune -a
```
```CLI
$ docker volume prune
```

**What are we looking at?**
The Common Ground base component provides a bit more than just a development interface, it also includes an example application and a backend that automatically hooks into your api. For now we're just going to focus on our api, but is good to read up on all the features of the Common Ground base component here.  

## Adding your own objects
You can now access your api at http://localhost:8080/, as you can see it's pre-loaded with some example objects. Let's replace them with your own objects!

First let's remove the objects currently in the api, we can do that by just removing the entities form our code base, navigate to the folder where you stored your code and open the folder api/src/Entity , you can find the example entities (our name for objects) there. Just delete all the php files in that folder.

Next let's add our own entities, we can do this in two ways, we can do old fashioned coding, but we can also use the build in maker bundle of the proto component, to quickly generate our entities for us (without the fuss of actual coding).
 
Let's open a new command line window and navigate to our root folder, exactly like we did under "spinning up your component". And then lets fire up maker bundle (make sure that your component is still running in your other command window). We can do so by the following command:

```CLI
$ docker-compose exec php bin/console make:entity
```
We should now see a wizward that allows us to either make new entities, or add parameters to existing entities (by supplying the name of an existing entity). 

## Keeping your repository up to date with the Conduction Common Ground component 

There are basically three reasons why you should want to keep your repository up to date with the Conduction proto component
* Security, Conduction performs regular security updates on 
* Functionality we strive to make regular 
* Compliance, as discussions in the broader Common Ground community progress API standars might advance or change. Conduction will regularly update the Common Ground component with those changes. 

Best practice is to fetch the Conduction Common Ground component into a local upstream/master branch through Git. So let's first add the original Common Ground component as an remote called upstream, and create a local branch for that remote.  

__Please make sure the you have commited al your changes to your current codebase and pushed a backup copy to your Git repo before continuing__

```CLI
git remote add upstream https://github.com/ConductionNL/Proto-component-commonground.git
git fetch upstream
git branch upstream upstream/master
```

You can then use your favorite Git tool to merge this branch into your normal working branche without the danger of overwriting your local code. Or alternatively you can use your GIT CLI (not  recommended)

```CLI
git checkout master
git pull upstream master --allow-unrelated-histories
```

You might get an error at this point in the lines of 'refusing to merge unrelated histories', that basically means that you lost your history connection with the original repository. This can happen for several reasons, but is easily fixable.

```CLI
git checkout upstream
git pull upstream master --allow-unrelated-histories
git checkout master
git merge upstream --allow-unrelated-histories
``` 

Keep in mind that you wil need to make sure to stay up to date about changes on the Common Ground component repository.

## Renaming your component
Right now the name of your component is 'commonground' that's thats fine while running it localy or in its own kubernetes cluster but wil get you in when running it with other components when it without using a name space. So its good practice to name your component distinctifly. But besides al of these practical reasons its of course also just cool to name your child before you unleas it on the unsuspecting commonground community.

Oke, so before we can nae the component we need to come up with a name. There are a couple of conventions here. Firts of the name should tell us what the component does, or is suposede to do with one or two words. So we would normaly call an componant aboute dogs the DogComponent and one about cats te CatComponent. The second convention is that we don't usually actually name our component 'component' but indicate its position in de commonground architecture. For that we have the following options
* Catalogus
* RegistratieComponent
* Service
* Application
* Tool

The we need to touch te following files
* .env
* dockercompose.yaml
* api/.env
* api/helm/values.yaml
* api/docker/nginx/

## Adding more openapi documantation

```php
//...
	/**
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *         	   "description" = "The name of a organisation",
	 *             "type"="string",
	 *             "format"="string",
	 *             "example"="My Organisation"
	 *         }
	 *     }
	 * )	 
	 */
	private $name;
//...	
```

## Setting up security and acces (also helps with serialization)

```PHP
// src/Entity/Organisation.php
namespace App\Entity;

// ...
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\OrganisationRepository")
 */
class Organisation
{
    /**
     * @Groups({"read","write"})
     */
    private $name;
}
```

## Using validation
Right now we are just accepting data and passing them on to the database, and in a mock or poc context this is fine. Most of the calls will end up being get requests anyway. But in case that we actually want our clients to make post to the api it would be wise to add some validation to the fields we are recieving. Luckely for us the component comes pre packed with a valdiation tool that we can configure from our entity through annotion. If we for example want to make a field required we could do so as follows: 

```PHP
// src/Entity/Organisation.php
namespace App\Entity;

// ...
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\OrganisationRepository")
 */
class Organisation
{
    /**
     * @Assert\NotBlank
     */
    private $name;
}
```

Keep in mind that we need to add the assert annotation to our class dependencies under 'use'.  

More inforation on using validation can be found at the [symfony website](https://symfony.com/doc/current/validation.html), but it is als worth notting that tis commonent comes pre packed with some typical NL valdidators like BSN. You can find those [here]().

## Using UUID
As default doctrine uses auto increment integers as identifiers (1,2, etc). For modern webapplications we howver prefer the use of UUID's. (e.g. e2984465-190a-4562-829e-a8cca81aa35d). Why? Wel for one it is more secure integer id's are easly gasable and make it posible to "aks" endpoint about objects that you should know about. But UUID's also have a benifit in futere proofing the application. If we in the futere want to merge a table with another table (for example becouse two organisations using a component perform a merger) then we would have to reasign al id's and relations if we where using int based id's (both tables would have a row 1,2 etc) with UUID's however the change of doubles range somwhere in the biljons. Meaning that it i likly that we oly need to either re identify only a handful of rows or more likely none at al! Turning our entire migration into a copy pase action.

The proto component supports ramsy's uuid objects stratagy out of the box, so to use UUID's as intifier simply we need to add the ApiProperty as a dependecy


```PHP
//...
use Symfony\Component\Serializer\Annotation\Groups;
//...
```
and  replace the default id property

```PHP
//...
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
//...
```
with

```PHP
//...
	/**
	 * @var \Ramsey\Uuid\UuidInterface
	 *
	 * @ApiProperty(
	 * 	   identifier=true,
	 *     attributes={
	 *         "openapi_context"={
	 *         	   "description" = "The UUID identifier of this object",
	 *             "type"="string",
	 *             "format"="uuid",
	 *             "example"="e2984465-190a-4562-829e-a8cca81aa35d"
	 *         }
	 *     }
	 * )
	 *
	 * @Groups({"read"})
	 * @ORM\Id
	 * @ORM\Column(type="uuid", unique=true)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
	 */
	private $id;
//..	
```

and remove the integer on the getter turning this:

```PHP
//...
    public function getId(): ?integer
    {
        return $this->id;
    }
//...
```

into this

```PHP
//...
    public function getId()
    {
        return $this->id;
    }
//...
```

and your all done

### Rrouble shooting
If you have already spunn your component including your new entity your going to run into some trouble becouse doctrine is going to try changing your primary key collum (id) from an integer to string (tables tend not to like that). In that case its best to just drop your database and reinstall it using the following commands:

```CLI
$ bin/console doctrine:schema:drop
$ bin/console doctrine:schema:update --force
```

## Advanced data sets

Oke lets make it complex, until now we have just added some simple entities to our component, but what if we want to ataches one entity to another? Fortunatly our build in database engine support rather complex senarios called associations. So let [take a look](https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/association-mapping.html) at that.  

Bafled? Wel its rather complex. But remember that Make:entity command that we used earlier? That actuelly accepts relations as a data type. Or to but it simply instead of using the default 'string' we could just type "ManyToOne" and it will just fire up some qoustions that will help it determine how you want your relations to be.


### Trouble shooting
A very common error when linking entities togehter is circle refrances, those will break our serializatoin. Furtunaltly we have a need way to prevent that. Even better symfony gives us exact control of how deep we want the circular refereance to go. To do this we need to use the `MaxDepth()` annotation. So lets import that 

```PHP
//...
use Symfony\Component\Serializer\Annotation\MaxDepth;
//...
```

And tell our serializer to use it.

```PHP
//...
/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ExampleEntityRepository")
 */
class ExampleEntity
	{
//...
```

We can now prevent circular referances by setting a max depth on the properties cousing the circular refrance.

//...
    /**
     * @var ArrayCollection $stuffs Some stuff that is atached to this example object
     * 
     * @MaxDepth(1)
     * @Groups({"read","write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Stuff", inversedBy="examples")
     */
    private $stuffs;     
//...
```

## Datafixtures
For testing cases it can be usefull to use datafixtures a predefined set of data that fills the database of your component at startup. Since we use php classes to describe our objects creating fixtures is easy (you can find an example in your project folder at api/src/DataFixtures). We simply go trough some classes asign values and persist them to the database. Once we have written our fixtures we can use a single command to load them  

```CLI
$ bin/console doctrine:fixtures:load --env=dev
```

Be mindfull of the --env=dev here! Doctrine wil only allow fixture loading on a dev enviroment (for obvius security reasons)

More inforation on using datafixtures can be found at the [symfony website](https://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html)(you can skipp the instalation instructions) we also enourage you to take a look at the [tabbelen component](https://github.com/ConductionNL/landelijketabellencatalogus) that makes extansive use of datafixtures.

## Sharing your work 
A vital part of te common ground community is sharing your work, and telling other people what you are working. This way people can help you wiht problems that you run into. And keep tabs on any (security) updates that you make to you code. Sounds like a lot of work right?

Wel it actually isn't, there is a specific commonground platform over at common-gorund.dev that reads repositorys and updates user. So the only thing we need to do is tell this platform that we have started a new common ground repository. And tell it when we have updates ours. We can do all that by simply adding a webhook to our component. 

When using Github. To set up a webhook, go to the settings page of your repository or organization. From there, click Webhooks, then Add webhook. Use te following settings:
* Payload URL: https://www.common-ground.dev/webhook/github
* Content type: Application/JSON
* Secret: [leave blanck]
* Events: [just the push event]

Now every time you update your repository the commonground dev page will allerted, rescan your repository and do al the apropriate platform actions. It just as easy as that.


Automated Testing and Deployment (continues integration)
-------
The following bit of the tutorial requires two additional accounts
- [https://hub.docker.com/](https://hub.docker.com/) (You might already have this for docker for desktop)
- [https://travis-ci.org](https://travis-ci.org) (You can use you github account)

The proto component ships with a pre-fab continues integration script based on travis. What does this mean you ask? Continuous integration (or CI for short) is an optimized and automated way for your code to become part of your projects. In the case of your commonground component that means that we will automatically validate new code commites or pushes and (if everything checks out) build that code and deploy the containers thereof to docker hub. Making is possible to update al the environments that use those components.

Oke that's nice, but how do we do that? Actually it is very simple. First of all make sure you have a docker account, log into [docker hub](https://hub.docker.com/) and have a look around. We don't need to create anything just yet'but it is nice to get a feeling of the place. As you can see docker hub also uses repositories etc. So that recognizable.

Next we need to prepare our github repository that holds our code. For the travis script to work as intended we need to create a couple of branches(if we don't have those already) open up yout git interface and create a branch called 'development' and a branch called 'staging'. Don't forget to push the branches so that they are present on github (and not just on your local machine).

Oke just one more place to go and that is travis, head over to [https://travis-ci.org](https://travis-ci.org) and login with your gitacount. If everything is alright you should see your repository there. Activate it by pressing 'activate repository' and then go to 'More options' -> 'Settings' and scroll down to enviroment variables. Here we can present travis wit the variables that it need to execute our build script. Lets first set the common variables that we need for all our branches: `DOCKER_PASSWORD` your docker password,`DOCKER_REGISTRY` docker.io/[your username] ,`DOCKER_USERNAME` your docker user name. This will be used by travis to push the completed containers into docker hub. Next we need to specify a couple of variables that are branch specific. Or to be more exact, set the same variable `APP_ENV` with different values for different branches. It needs to be 'staging'->stag,'master'->prod,'development'->dev.

And all done! Head over back to the code on your computer and make a small change. Then commit push that change into github. Travis should automatically pick op your change and start a build.


### Unit / Behat

adas

### Postman
ad

### Trouble shooting
Please make sure that your github repositry is set to public, and keep in mind that a complex travis build (and sertenly one that includes a pushing of containers can take up to 20 minutes)

Documentation and dockblocks
-------
asdsa

Audittrail
-------
As you might expect the proto-component ships with a neat function for generating audit trails, that basically exist of three parts. 

First we need to activate logging on the entities that we want logged (for obvious security reasons we don't log entity changes by default) to do that by adding the `@Gedmo\Loggable` annotation to our php class, which should then look something like:

```PHP
//...
/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ExampleEntityRepository")
 * @Gedmo\Loggable
 */
class ExampleEntity
	{
//...
```

Next we need to tell the specific properties that we want to log that they are loggable (again this is a conscious choice, to prevent us from accidently logging stuff like bsn numbers), we do that by adding the `@Gedmo\Versioned` annotation to those specific properties. That would then look something like this:

```PHP
//...
    /**
	 * @var string $name The name of this example property
	 * @example My Group
	 * 
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      max = 255
	 * )
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;
//...
```

Okay actually we are now good to go, at least we are logging those things that we want logged. But.... How do we view those logs? In commonground we have a [convention](https://zaakgerichtwerken.vng.cloud/themas/achtergronddocumentatie/audit-trail) to expose a /audittrail subresource on resources that are logged. So lets add that trough our `@ApiResource` anotation.

```PHP
//...
/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ExampleEntityRepository")
 * @Gedmo\Loggable
 */
class ExampleEntity
	{
//...
```

And now we have a fully nl api strategie integrated audit trail!


Setting up automated deployment (continues delivery)
-------
adasd

## Commonground specific data types


### incompleteDate

### underInvestigation

