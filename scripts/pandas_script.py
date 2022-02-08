import pandas as pd, os, numpy

# Change directory
os.chdir('C:\\Users\\gabri\\Documents\\JuniorYear\\JuniorSecondSemester\\COMP0022\\COMP0022-Database')

#Used to check types: df.dtypes

#Used to check if any null values: df.isnull().sum()
#Used to grab the null rows: df[df['tmdbId'].isnull()]

#Used to check if a column has duplicates: df['tmdbId'].duplicated().any()
#Used to locate duplicate rows of a specific column: df.loc[df['tmdbId'] == SOMEVALUE]

# Read:

# tmdb_id column has null values
# tmdb_id column has duplicates
links_table = pd.read_csv("ml-latest-small\\links.csv") 

# titles,year have duplicates
# year has null values
movies_table = pd.read_csv("ml-latest-small\\movies.csv")
movies_table[['title', 'year']] = movies_table['title'].str.rsplit(" ", n=1, expand=True)
movies_table['year'] = movies_table['year'].str.replace('(', '')
movies_table['year'] = movies_table['year'].str.replace(')', '')

genres = {"action": [], "adventure": [], "animation": [], "children": [], "comedy": [], "crime": [], "documentary": [], "drama": [], "fantasy": [], "film-noir": [], "horror": [], "musical": [], "mystery": [], "romance": [], "sci-fi": [], "thriller": [], "war": [], "western": []}
keys = list(genres.keys())         

for row in movies_table['genres'].str.rsplit("|"):
    for key in keys:
        if key.capitalize() in row:
            genres[key].append(1)
        else:
            genres[key].append(0)

for key in genres:
    genres[key] = numpy.array(genres[key])

for key in genres:
    movies_table[key] = genres[key]

movies_table.drop('genres', axis=1, inplace=True)

movies_table = pd.merge(movies_table, links_table, on=['movieId','movieId'])

movies_table.rename(columns={'movieId': 'movie_id', 'imdbId': 'imdb_id', 'tmdbId': 'tmdb_id'}, inplace=True)
movies_table = movies_table[['movie_id', 'title', 'year', 'imdb_id', 'tmdb_id', 'action', 'adventure', 'animation',
       'children', 'comedy', 'crime', 'documentary', 'drama', 'fantasy',
       'film-noir', 'horror', 'musical', 'mystery', 'romance', 'sci-fi',
       'thriller', 'war', 'western']]
