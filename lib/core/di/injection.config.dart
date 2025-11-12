// GENERATED CODE - DO NOT MODIFY BY HAND
// dart format width=80

// **************************************************************************
// InjectableConfigGenerator
// **************************************************************************

// ignore_for_file: type=lint
// coverage:ignore-file

// ignore_for_file: no_leading_underscores_for_library_prefixes
import 'package:get_it/get_it.dart' as _i174;
import 'package:injectable/injectable.dart' as _i526;
import 'package:shared_preferences/shared_preferences.dart' as _i460;

import '../../features/counter/data/datasources/counter_local_data_source.dart'
    as _i976;
import '../../features/counter/data/repositories/counter_repository_impl.dart'
    as _i770;
import '../../features/counter/domain/repositories/counter_repository.dart'
    as _i514;
import '../../features/counter/domain/usecases/decrement_counter.dart' as _i478;
import '../../features/counter/domain/usecases/get_counter.dart' as _i245;
import '../../features/counter/domain/usecases/increment_counter.dart' as _i931;
import '../../features/counter/domain/usecases/reset_counter.dart' as _i949;
import '../../features/counter/presentation/bloc/counter_bloc.dart' as _i256;

extension GetItInjectableX on _i174.GetIt {
  // initializes the registration of main-scope dependencies inside of GetIt
  _i174.GetIt init({
    String? environment,
    _i526.EnvironmentFilter? environmentFilter,
  }) {
    final gh = _i526.GetItHelper(this, environment, environmentFilter);
    gh.factory<_i976.CounterLocalDataSource>(
      () => _i976.CounterLocalDataSourceImpl(gh<_i460.SharedPreferences>()),
    );
    gh.factory<_i514.CounterRepository>(
      () => _i770.CounterRepositoryImpl(gh<_i976.CounterLocalDataSource>()),
    );
    gh.factory<_i478.DecrementCounter>(
      () => _i478.DecrementCounter(gh<_i514.CounterRepository>()),
    );
    gh.factory<_i245.GetCounter>(
      () => _i245.GetCounter(gh<_i514.CounterRepository>()),
    );
    gh.factory<_i931.IncrementCounter>(
      () => _i931.IncrementCounter(gh<_i514.CounterRepository>()),
    );
    gh.factory<_i949.ResetCounter>(
      () => _i949.ResetCounter(gh<_i514.CounterRepository>()),
    );
    gh.factory<_i256.CounterBloc>(
      () => _i256.CounterBloc(
        getCounter: gh<_i245.GetCounter>(),
        incrementCounter: gh<_i931.IncrementCounter>(),
        decrementCounter: gh<_i478.DecrementCounter>(),
        resetCounter: gh<_i949.ResetCounter>(),
      ),
    );
    return this;
  }
}
