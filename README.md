# [barcode-coder.com](barcode-coder.com)

Port from PHP to static website.

This project can be built / served directly using [jekyll](https://jekyllrb.com/) or using jekyll through [docker](https://www.docker.com/). 

## Case 1: Jekyll is installed on the machine

  ### Build
  ```bash
  jekyll build
  ```
  
  ### Serve while development
  ```bash
  jekyll serve
  ```

## Case 2: docker is installed on the machine

  ### Build
  ```bash
  ./docker/build.sh
  ```
  
  ### Serve while development
  ```bash
  ./docker/serve.sh
  ```
