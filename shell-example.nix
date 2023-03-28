{ pkgs ? import <nixpkgs> {} }:
let
  pkgs22 = import (pkgs.fetchFromGitHub {
    owner  = "NixOS";
    repo   = "nixpkgs";
    rev    = "22.05";
    sha256 = "M6bJShji9AIDZ7Kh7CPwPBPb/T7RiVev2PAcOi4fxDQ=";
  }) {};
  php = with pkgs22; (php81.buildEnv {
    extensions = {all , enabled} : enabled ++ [
      (php81.buildPecl {
        pname = "grpc";
        version = "1.46.3";
        sha256 = "Kq1hIwr9oxku7a0lvpGL2mKOaqGL8e1+O88ZRObk9NU=";
        nativeBuildInputs = [zlib.dev zlib.out];
      })
    ];
  });
in
pkgs.mkShell {
  shellHook = ''
    alias serve="php artisan serve"
  '';
  nativeBuildInputs = [
    php
    php.packages.composer
  ] ++ (with pkgs; [
  ]);
}
