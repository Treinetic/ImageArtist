# Changelog
# 1.0.0 (Ready For The World) - 2017-09-24
- We feel we are stable enough go live.

# 0.3.1 (beta) Released - 2017-09-24
- Bug fixed on Text angles, both in Imagick Writing Strategy as well as GDWritingStrategy
- More minor improvements, I think we are ready for the first release version of ImageArtist :) 

# 0.3.0 (alpha) Released - 2017-09-13
- TextWriting Strategy was previously switched automatically based on imageick and pango avialability, with this version we are providing another method called 'WriteFactory.overrideWriteStrategySelection()' to manually switch between writing strategies
- 'flipH()', 'flipV()', 'rotate($degrees)' methods added to 'Image.php'
- For fixing Orientation based on exif value 'OrientationFixer.php' helper added

# 0.2.1 patch Released - 2017-09-12 
there was a bug in the `Rectangle.php` for the older php versions


# 0.2.0 (alpha) Released - 2017-09-12
- method `getBase64URL` renamed to `getDataURI` in `Image.php` 
- strategy pattern implemented for textWriting to decide which writer ( gd or imagick ) to be selected, we decided to go for this to support complex unicode rendering

# 0.1.0-alpha Released - 2017-09-10
0.1.0 alpha release with lot of code optimizations and more hidden bug fixes, this include 
- Image merge function is now supoorting negative cordinates
- PolygonShape.php build method was not shrinking to the shape size bug fixed.
- Rectangle.php helper was added wrapping some linear algebric logic to support image croping and boundary calculations
- Square Shape added ( but it may get renamed soon )


# 0.1.0-alpha-rc1
0.1.0 alpha candidate is now progressing, more focused on code stability and build more functionality ontop of the current core libraries

# 0.0.1-alpha - 2017-09-08
- Contriubtion team did the first release of ImageArtist for internal use of the company project, this first release is having following features
### Features
- Polygon and the CircleShape aded 
- TextBox for Text writing on top of Images
- Overlay creationg
- Powerfull class for basic image operations like resizing, cropping, saving to differnt format etc


# First Breath (Repo Created)
- Imal hasaranga perera CEO of Treinetic (pvt) took the first step of writing an interactive easy to use image manipulation library after understaning the waste of time and huge number of code lines that developers has to write just to get done a simple image manipulation task done

