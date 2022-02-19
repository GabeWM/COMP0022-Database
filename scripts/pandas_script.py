import pandas as pd, os, numpy, datetime

#Change directory
os.chdir('C:\\Users\\gabri\\Documents\\JuniorYear\\JuniorSecondSemester\\COMP0022\\COMP0022-Database')

#Used to check types: df.dtypes

#Used to check if any null values: df.isnull().sum()
#Used to grab the null rows: df[df['tmdbId'].isnull()]

#Used to check if a column has duplicates: df['tmdbId'].duplicated().any()
#Used to locate duplicate rows of a specific column: df.loc[df['tmdbId'] == SOMEVALUE]
#Used to get duplicate rows: df[df['userid'].duplicated()]

#Used to see all columns: pd.set_option('display.max_columns', None)

pd.set_option('display.max_columns', None)

############################################ MOVIES TABLE #############################################

#tmdb_id column has null values
#tmdb_id column has duplicates
links_table = pd.read_csv("data\\original_data\\ml-latest-small\\links.csv") 

#titles,year have duplicates
#year has null values
movies_table = pd.read_csv("data\\original_data\\ml-latest-small\\movies.csv")
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
#movies_table.to_csv('movies_table.csv', index=False, encoding='utf-8')

############################################ PERSONALITY TABLE/PREDICTIONS TABLE #############################################

#Duplicate rows

personality_table_original = pd.read_csv("data\\original_data\\personality-isf2018\\personality-data.csv")
personality_table_original = personality_table_original.drop_duplicates()
personality_table_original.columns = personality_table_original.columns.str.strip()
personality_table_original = personality_table_original.drop([750])

#No null values
#user_id has a single duplicate (will drop it)
personality_table = personality_table_original.iloc[: , 0:8]
personality_table = personality_table.join(personality_table_original["is_personalized"])
personality_table = personality_table.join(personality_table_original["enjoy_watching"])

personality_table.rename(columns={'userid': 'personality_id', 'assigned metric': 'assigned_metric', 'assigned condition': 'assigned_condition'}, inplace=True)
personality_table = personality_table[['personality_id', 'assigned_metric', 'assigned_condition', 'openness', 'agreeableness',
                                       'emotional_stability', 'conscientiousness', 'extraversion', 'is_personalized', 'enjoy_watching']]
#personality_table.to_csv('personality_table.csv', index=False, encoding='utf-8')

#No null values
#No duplicates
drop = [33,32,7,6,5,4,3,2,1]
for i in drop:
    personality_table_original.drop(personality_table_original.columns[i], axis=1, inplace=True)

predictions = {"personality_id": [], "movie_id": [], "prediction": []}
                   
for index, row in personality_table_original.iterrows():
    personality_id = row[0]
    for i in range(1,len(row),2):
        predictions["personality_id"].append(personality_id)
        predictions["movie_id"].append(row[i])
        predictions["prediction"].append(row[i+1])

for key in predictions:
    predictions[key] = numpy.array(predictions[key])

predictions_table = pd.DataFrame(predictions) 

#predictions_table.to_csv('predictions_table.csv', index=False, encoding='utf-8')

############################################ RATINGS TABLE #############################################

#No null values
#No duplicates
ratings_table = pd.read_csv("data\\original_data\\ml-latest-small\\ratings1.csv")
ratings_table.columns = ratings_table.columns.str.strip()

ratings_table['timestamp'] = ratings_table['timestamp'].apply(lambda x: datetime.datetime.fromtimestamp(x).strftime('%c'))

ratings_table['personality_id'] = numpy.nan

temp_table = pd.read_csv("data\\original_data\\personality-isf2018\\ratings.csv")

ratings_dict = {'userId': [], 'movieId': [], 'rating': [], 'timestamp': [], 'personality_id': []}
personality_id_set = set()
user_id_curr = 610

for index, row in temp_table.iterrows():
    if row[0] not in personality_id_set:
        personality_id_set.add(row[0])
        user_id_curr += 1
        
    ratings_dict['userId'].append(user_id_curr)
    ratings_dict['movieId'].append(row[1])
    ratings_dict['rating'].append(row[2])
    ratings_dict['timestamp'].append(row[3])
    ratings_dict['personality_id'].append(row[0])
    
for key in ratings_dict:
    ratings_dict[key] = numpy.array(ratings_dict[key])

ratings_table_append = pd.DataFrame(ratings_dict)
ratings_table_append['timestamp'] = ratings_table_append['timestamp'].apply(lambda x: datetime.datetime.strptime(x.strip(), '%Y-%m-%d %H:%M:%S').strftime('%c'))
ratings_table = ratings_table.append(ratings_table_append, ignore_index=True)

ratings_table.rename(columns={'userId': 'user_id', 'movieId': 'movie_id'}, inplace=True)
ratings_table.to_csv('ratings_table.csv', index=False, encoding='utf-8')

############################################ TAGS TABLE #############################################

#No null values
#No duplicates
tags_table = pd.read_csv("data\\original_data\\ml-latest-small\\tags.csv")

tags_table['timestamp'] = tags_table['timestamp'].apply(lambda x: datetime.datetime.fromtimestamp(x).strftime('%c'))

#Does not give index label
tags_table.rename(columns={'userId': 'user_id', 'movieId': 'movie_id'}, inplace=True)
tags_table.to_csv('tags_table.csv', index=True, encoding='utf-8')