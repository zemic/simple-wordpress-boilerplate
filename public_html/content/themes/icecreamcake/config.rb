#----------------------------------------------------------------#
# Sass / Compass Configuration File
#----------------------------------------------------------------#

#----------------------------------------------------------------#
# 1. Set this to the root of your project when deployed:
#----------------------------------------------------------------#
http_path = "/"

#----------------------------------------------------------------#
# 2. FILE STRUCTURE
# All paths are relative to the project_path.
#----------------------------------------------------------------#
css_dir         = "assets/css"    # The directory where the css stylesheets are kept.
sass_dir        = "assets/scss"   # The directory where the sass stylesheets are kept.
images_dir      = "assets/images" # The directory where images are kept.
javascripts_dir = "assets/js"     # The directory where the javascripts are kept.
fonts_dir       = "assets/fonts"  # The directory where fonts are kept.
relative_assets = true            # Indicates whether the compass helper functions should generate relative urls from the generated css to assets, or absolute urls using the http path for that asset type.

#----------------------------------------------------------------#
# 3. PREFERRED SYNTAX
#----------------------------------------------------------------#
preferred_syntax = :scss

#----------------------------------------------------------------#
# 4. ENVIRONMENT / OUTPUT CONTROL
#
# ***Important***
# Starting in CodeKit 2.1.9, compiling options (output style,
# debug information, source maps, etc.) for Sass files in a Compass
# project are controlled solely in CodeKit's UI. The process works
# just like it does for Sass files in a non-Compass project. The
# settings for these options in the Compass config.rb file will be
# overridden by the settings in CodeKit's UI.
#
# Output paths must still be set by editing the config.rb file because
# Compass does not have an API that allows me to control the output
# path directly.
#----------------------------------------------------------------#
environment     = :production   # The environment mode :production, or :development . Use :production on live sites
line_comments   = false         # This should be false on live sites
output_style    = :compressed   # The output style for the compiled css. One of: :nested, :expanded, :compact, or :compressed. Use output_style = :compressed on live web sites
