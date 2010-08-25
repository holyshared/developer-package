Frontend Developer Package 1.0.1b
=================================

Frontend Developer Package is a package for a small-scale open source software development person.

Front end developer (HTML,CSS,javascript,Design) is chiefly targeted.

The block and the theme for the open source software development person to be able to open a troublesome project site to the public as soon as possible are contained. 
It comes to be able to construct the project site with concrete5 early by using this package.

**author** - [Noritaka Horio](http://sharedhat.com)
**licence** - [The MIT Licence](http://www.opensource.org/licenses/mit-license.php)
**contact** - [Contact](mailto:holy.shared.design@gmail.com)


Method of installation
--------------------------------

1. The folder defrosted under the packages directory is copied. 
2. The site is logged in. 
3. "Add Functionality" menu is clicked. 
4. The installation button of "Frontend Developer Package" is clicked from the package of lower right that can be installed. 
5. If the message of "A new package was installed" is displayed, it is installation completion. 


Setting before it uses it
--------------------------------

The setting is necessary for using this package. 
Please confirm and set the block and the single page to be used. 

### Access permit of javascript

**Mootools Plugin Build Form block**When is used, it is necessary to permit the access of the javascript file.
The import cannot do the javascript file from the repository of github to the file manager if it doesn't permit.
Therefore, please permit.

#### Procedure

1. The file manager menu is clicked. 
2. The access authority is clicked. 
3. "js" is added to the permitted file extension. 
4. If the input content is displayed, it is completion. 



### Addition of name of github user

**Mootools Plugin Build Form, Github Issues, Github Repository, and Github Tags block**When is used, 
it is necessary to input the name of the user of github to user's attribute information. 
The list of the ticket, tag, and the repository cannot be acquired by way of API of github when there is no input. 
Therefore, please input it. 

#### Procedure

1. The user groups management is clicked. 
2. The name of the user of the list is clicked. 
3. The user edit of upper right is clicked. 
4. The nether name of the github user is clicked most. 
5. The name of the github user is input to the input column. 
6. A right edit icon is clicked, and the content is reflected. 
7. If the input content is displayed, it is completion. 


About the block
--------------------------------

It is an explanation of the included block in this package. 

### Mootools Plugin Build Form
A downloadable form such as Core Builder (http://mootools.net/core) of mootools.net and More Builder (http://mootools.net/more) to customize is offered. 
YUI Compressor, JSMin, and no compression can be selected the compressed format moreover when downloading it. 

### Github Issues
The ticket list of github is displayed. 
The displayed number of tickets can be specified. 

### Github Repository
The repository list of github is displayed. 
The displayed repository can be specified. 

### Github Tags
[Taguririsuto] of github is displayed. 
The number of displayed tag can be specified. 


About the theme
--------------------------------

### Small Project

It is a theme made for this package. 
Page type supports the following. 

#### Page type

* Full display
* Left navigation

Default is a left navigation. 

#### Custom template

The custom template for the default block of concrete5 is contained. 

##### Auto Nabis

* ** Template for Small Project Topic Menu**- topic path
* ** Template for Small Project Local Menu**- local navigation
* ** Template for Small Project Header Menu**- header navigation
* ** Template for Small Project Dooter Menu**- footer navigation

##### Contents

* ** Template for Small Project Module**- module
* ** Template for Small Project Line**- grid

Please refer to oocss (http://wiki.github.com/stubbornella/oocss/) for the module and the grid. 



Method of uninstallation
--------------------------------

1. The site is logged in. 
2. "The function is added" menu is clicked. 
3. The edit button of Frontend Developer Package displayed in the package that has been installed is clicked. 
4. Nether "The package is deleted" is clicked most. 
5. "The package is deleted" in the lower right of the confirmation screen is clicked. Please click the cancellation when you do not want to delete it. 
6. If the message of "The package was deleted" is displayed, it is uninstallation completion. 