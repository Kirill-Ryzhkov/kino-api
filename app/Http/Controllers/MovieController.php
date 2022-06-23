<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    /**
     * @api v1
     * Метод нужен для получения всех фильмов или ограниченное их кол-во, с выбором сортировки и направлением сортировки.
     * @author Kirill Ryzhkov <slusc10a@gmail.com>
     * @param int       $limit      Не обязательный параметр, по умолчанию передается -1 (вывод всех запесей). Передавая его можно ограничить кол-во выводимых строк(фильмов)
     * @param string    $order      Не обязательный параметр, по умолчанию передается "nameOriginal". Передавая его можно сортировать вывод по тому полю, который нам нужен. Допустимые поля - nameRu, year, age, filmLength, ratingImdb
     * @param string    $dir        Не обязательный параметр, по умолчанию передается "asc". Передавая его можно выводить в различных направлениях ("asc" - а-я, 1-10; "desc" - я-а, 10-1)
     * @return array[]
     * @example localhost:8000/api/movies/all
     * @example localhost:8000/api/movies/all/10/nameRu/desc
     */
    public function getLimited($limit = -1, $order = "nameOriginal", $dir = "asc"){
        $limitMovies = DB::table('movies')
                                -> orderBy($order, $dir)
                                -> limit($limit)
                                -> get();
        return $limitMovies;            
    }
    /**
     * @api v1
     * Метод нужен для получения всех фильмов по году выпуска или позже/раньше года выпуска.
     * @author Kirill Ryzhkov <slusc10a@gmail.com>
     * @param int       $year       Обязательный параметр. Передаем год выпуска, по которому хотим найти фильм
     * @param string    $dir        Не обязательный параметр, по умолчанию передается "equal". Передавая его можно сортировать вывод по точному году (equal), позже (later), раньше (early) 
     * @return array[]
     * @example localhost:8000/api/movies/year/2003
     * @example localhost:8000/api/movies/year/2003/later
     */
    public function getYear($year, $dir = "equal"){
        if($dir == "equal"){
            $movieYear = DB::table('movies') 
                        -> where('year', '=', $year)
                        -> get();
        } elseif ($dir == "later"){
            $movieYear = DB::table('movies') 
                        -> where('year', '>=', $year)
                        -> get();
        } elseif ($dir == "early"){
            $movieYear = DB::table('movies') 
                        -> where('year', '<=', $year)
                        -> get();
        } else {
            $movieYear = "Wrong parameter";
        }
        
        return $movieYear;
    }

    /**
     * @api v1
     * Метод нужен для получения всех фильмов по названию на языке оргинала и на русском.
     * @author Kirill Ryzhkov <slusc10a@gmail.com>
     * @param string    $name        Обязательный параметр. Передавая его можно найти фильм по названию на русском или на английсом языке 
     * @return array[]
     * @example localhost:8000/api/movies/name/Матрица
     * @example localhost:8000/api/movies/name/Matrix
     */
    public function getName($name){
        $getName = DB::table('movies')
                            -> where ('nameOriginal', 'like', "%$name%")
                            -> orWhere ('nameRu', 'like', "%$name%")
                            -> get();
        return $getName;
    }

    /**
     * @api v1
     * Метод нужен для получения всех фильмов по жанру.
     * @author Kirill Ryzhkov <slusc10a@gmail.com>
     * @param string    $genre        Обязательный параметр. Передавая его можно найти фильм по жанру. Передавать можно как один жанр (драма), так и несколько через запятую (боевик,фантастика)
     * @return array[]
     * @example localhost:8000/api/movies/genre/драма
     * @example localhost:8000/api/movies/genre/боевик,фантастика
     * @example localhost:8000/api/movies/genre/Боевик, фАнтас тика
     */
    public function getGenre($genre){
        if(Str::contains($genre, ',')){
            $genres = explode(",", $genre);
            $filterGenres = [];
            foreach ($genres as $genre){
                $genre = mb_strtolower(str_replace(" ", "", $genre));
                $filterGenres[] = ['genres', 'like', "%$genre%"];
            }
            $getGenre = DB::table('movies')
                        -> where ($filterGenres)
                        -> get();
        } else {
            $getGenre = DB::table('movies')
                        -> where ('genres', 'like', "%$genre%")
                        -> get();
        }
        return $getGenre;
    }

    /**
     * @api v1
     * Метод нужен для получения всех фильмов по его продолжительности в минутах или больше/меньше в минутах.
     * @author Kirill Ryzhkov <slusc10a@gmail.com>
     * @param int       $length     Обязательный параметр. Передаем кол-во минут фильма
     * @param string    $dir        Не обязательный параметр, по умолчанию передается "equal". Передавая его можно сортировать вывод по точному кол-ву минут (equal), больше заданной продолжительности (more), меньше заданной продолжительности (less) 
     * @return array[]
     * @example localhost:8000/api/movies/year/2003
     * @example localhost:8000/api/movies/year/2003/later
     */
    public function getLength($length, $dir = 'equal'){
        if($dir == "equal"){
            $movieLength = DB::table('movies') 
                        -> where('filmLength', '=', $length)
                        -> get();
        } elseif ($dir == "more"){
            $movieLength = DB::table('movies') 
                        -> where('filmLength', '>=', $length)
                        -> get();
        } elseif ($dir == "less"){
            $movieLength = DB::table('movies') 
                        -> where('filmLength', '<=', $length)
                        -> get();
        } else {
            $movieLength = "Wrong parameter";
        }
        
        return $movieLength;
    }
}

